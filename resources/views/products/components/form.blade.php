<form
	action="{{isset($product) ? route('products.update', ['id' => $product->id]) : route('products.store')}}"
	method="POST"
	enctype="multipart/form-data">
	{{csrf_field()}}
	<input type="text" name="name" placeholder="Product name" value="My great product {{rand(1,100)}}">
	<gallery-creator :images="{{$product->images ?? null}}"></gallery-creator>
	<button>{{isset($product) ? 'Uppdatera' : 'Spara'}}</button>
</form>
