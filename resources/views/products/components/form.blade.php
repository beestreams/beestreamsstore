<form
	action="{{isset($product) ? route('products.update', ['id' => $product->id]) : route('products.store')}}"
	method="POST"
	enctype="multipart/form-data">

	{{csrf_field()}}

    <div class="product-from__input-wrap">
        <label for="name" class="products-form__label">Name</label>
        <input 
            type="text" 
            name="name" 
            placeholder="Product name" 
            value="{{$product->name ?? ''}}">
    </div>
    
    <div class="product-form__input-wrap">
        <label for="description" class="products-form__label">Description</label>
        <textarea 
            class="products-form__description" 
            name="description"></textarea>
    </div>
    <div class="product-form__dimensions">
        <div class="product-form__input-wrap">
            <label for="width" class="products-form__label">Width</label>
            <input 
                type="text"
                name="width" 
                placeholder="Product width" 
                value="{{$product->width ?? ''}}">
        </div>

        <div class="product-form__input-wrap">
            <label for="height" class="products-form__label">Height</label>
            <input 
                type="text" 
                name="height" 
                placeholder="Product height" 
                value="{{$product->height ?? ''}}">
        </div>

        <div class="product-form__input-wrap">
            <label for="depth" class="products-form__label">Depth</label>
            <input 
                type="text" 
                name="depth" 
                placeholder="Product depth" 
                value="{{$product->depth ?? ''}}">
        </div>
    </div> 
    
    <div class="product-form__input-wrap">
        <label for="quantity" class="products-form__label">Quantity</label>
        <input
            type="text"
            class="products-quantity"
            name="quantity"
            placeholder="Quantity in stock"
            value="{{$product->quantity ?? ''}}">
    </div>
    <gallery-creator :images="{{$product->images ?? json_encode([])}}"></gallery-creator>

	<button id="product-form__submit">{{isset($product) ? 'Uppdatera' : 'Spara'}}</button>
</form>
