<template>
	<section class="galleryCreator">
        <!-- Existing images -->
        
        <!-- Add images -->
        <div v-for="(inputId, index) in inputIds">
            <image-picker :fileId="inputId"></image-picker>
        </div>
        <button @click.prevent="addPicker">Add image</button>

	</section>
</template>
<script>
    import ImagePicker from './ImagePicker.vue';
	export default {

        components: {
            'image-picker': ImagePicker
        },
        props: {
            images: {default :[]}
        },

        data() {
            return {
                inputIds: [1]
            }
        },

        computed: {

        },

        methods: {
        	addPicker (e) {
                let lastNum = this.inputIds[this.inputIds.length - 1];
                this.inputIds.push(lastNum+1);
                return true;
        	},
        }
    }
</script>
