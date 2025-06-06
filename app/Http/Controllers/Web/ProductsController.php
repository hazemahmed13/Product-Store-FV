<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller {

	use ValidatesRequests;

	public function __construct()
    {
        // Remove auth middleware to allow public access
    }

	public function list(Request $request) {

		$query = Product::select("products.*");

		$query->when($request->keywords, 
		fn($q)=> $q->where("name", "like", "%$request->keywords%"));

		$query->when($request->min_price, 
		fn($q)=> $q->where("price", ">=", $request->min_price));
		
		$query->when($request->max_price, fn($q)=> 
		$q->where("price", "<=", $request->max_price));
		
		$query->when($request->order_by, 
		fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

		$products = $query->get();

		return view('products.list', compact('products'));
	}

	public function edit(Request $request, Product $product = null) {

		if(!auth()->user()) return redirect('/');

		$product = $product??new Product();

		return view('products.edit', compact('product'));
	}

	public function save(Request $request, Product $product = null) {

		$this->validate($request, [
	        'code' => ['required', 'string', 'max:32'],
	        'name' => ['required', 'string', 'max:128'],
	        'model' => ['required', 'string', 'max:256'],
	        'description' => ['required', 'string', 'max:1024'],
	        'price' => ['required', 'numeric'],
	        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
	    ]);

		$product = $product ?? new Product();
		$product->fill($request->except('image'));

		try {
			if ($request->hasFile('image')) {
				$file = $request->file('image');
				
				// Check if file is valid
				if (!$file->isValid()) {
					return back()->withInput()->withErrors(['image' => 'Invalid file upload']);
				}

				// Delete old image if exists
				if ($product->image && Storage::disk('public')->exists($product->image)) {
					try {
						Storage::disk('public')->delete($product->image);
					} catch (\Exception $e) {
						\Log::error('Failed to delete old image: ' . $e->getMessage());
					}
				}

				// Generate unique filename
				$filename = time() . '_' . $file->getClientOriginalName();
				
				// Store the new image
				$path = $file->storeAs('products', $filename, 'public');
				
				if (!$path || !Storage::disk('public')->exists($path)) {
					return back()->withInput()->withErrors(['image' => 'Failed to upload image']);
				}
				
				$product->image = $path;
			}

			$product->save();
			return redirect()->route('products_list')->with('success', 'Product saved successfully');
			
		} catch (\Exception $e) {
			\Log::error('Product save error: ' . $e->getMessage());
			return back()->withInput()->withErrors(['general' => 'Failed to save product: ' . $e->getMessage()]);
		}
	}

	public function delete(Request $request, Product $product) {

		if(!auth()->user()->hasPermissionTo('delete_products')) abort(401);

		try {
			// Delete the image file if it exists
			if ($product->image && Storage::disk('public')->exists($product->image)) {
				try {
					$deleted = Storage::disk('public')->delete($product->image);
					if (!$deleted) {
						\Log::warning('Failed to delete image file: ' . $product->image);
					}
				} catch (\Exception $e) {
					\Log::error('Error deleting image: ' . $e->getMessage());
				}
			}

			$product->forceDelete();
			return redirect()->route('products_list')->with('success', 'Product deleted successfully');
			
		} catch (\Exception $e) {
			\Log::error('Product delete error: ' . $e->getMessage());
			return back()->withErrors(['general' => 'Failed to delete product: ' . $e->getMessage()]);
		}
	}
} 






































