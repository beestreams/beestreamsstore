<template>
	<section class="galleryCreator">
        <!-- Existing images -->
       <div v-for="(image, index) in images">
           <image-handler :image="image"></image-handler> 
       </div> 
        <!-- Add images -->
        <div v-for="(inputId, index) in inputIds">
            <image-picker :fileId="inputId"></image-picker>
        </div>
        <button id="gallery-creator__add-image" @click.prevent="addPicker">Add image</button>

	</section>
</template>
<script>
    import ImagePicker from './ImagePicker.vue';
    import ImageHandler from './ImageHandler.vue';
	export default {

        components: {
            'image-picker': ImagePicker,
            'image-handler': ImageHandler
        },
        props: {
            images: Array
        },

        data() {
            return {
                inputIds: [0]
            }
        },

        methods: {
        	addPicker (e) {
                let lastNum = this.inputIds[this.inputIds.length - 1];
                this.inputIds.push(lastNum+1);
                return true;
        	}
        }
    }
</script>
