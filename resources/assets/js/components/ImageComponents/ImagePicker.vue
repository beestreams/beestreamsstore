<template>
	<!-- Filepicker with preview box. -->
	<section class="filePicker image">
		<div 
            class="filePicker__preview"
            :style="styleObject"></div>

		<div class="buttons">

			<input 
                :id="fileInputID"
                class="imageInput"
                type="file"
                @change="updateBackground"
                :name="namespace + '['+fileId+']'"
                value=""/>
            
            <div class="image-picker__input-wrap">
                <label :for="namespace + '['+fileId+']'">Caption</label>
                <input
                 type="text"
                 :name="namespace + '_alt_text['+fileId+']'"
                 value="">
            </div>
	    	
            <button
                @click.prevent="clickFileInput"
                class="button filePicker__choose">Välj bild</button>
            <button
                @click.prevent="clearImage"
                class="button danger filePicker__clear">Clear</button>
		</div>
	</section>
</template>
<script>
	export default {

        props: {
            namespace: { default:'images' },
            fileId: { default: 0 }
        },

        data() {
            return {
                reader: new FileReader(),
                imageData: null
            }
        },

        computed: {
            styleObject() {
                let styles = {};
                if (this.imageData) {
                    styles.backgroundImage = 'url('+this.imageData+')';
                } else {
                    styles.backgroundImage = "url('http://placekitten.com/g/300/300')";
                }
                return styles;
            },
        	fileInputID() { return 'fileInput'+this.fileId; }
        },
        methods: {
            clearImage () {
                document.getElementById(this.fileInputID).value = '';
                this.imageData = '';
            },
        	clickFileInput (e) {
                document.getElementById(this.fileInputID).click();
        	},
            updateBackground (e) {
				let file = e.target.files[0];

			    this.reader.onload = function (e) {
                    this.imageData = e.target.result;
			    }.bind(this);

			    this.reader.readAsDataURL(file);
            }
        }
    }
</script>
