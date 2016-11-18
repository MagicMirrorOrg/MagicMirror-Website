<template>
    <div class="uploader">
        <div class="alert alert-danger" v-if="error"><strong><i class="fa fa-exclamation-triangle"></i> Upload failed.</strong> {{error}}</div>
        <div v-if="!remoteFileName">
            <div class="dropzone-area" @dragenter="hovering = true" @dragleave="hovering = false" :class="{'dropzone-hover': hovering}">
                <div class="dropzone-background" v-bind:style="{ backgroundImage: 'url(' + image + ')' }"></div>
                <div class="dropzone-text" v-if="!uploading">
                    <i class="dropzone-icon fa fa-image fa-3x"></i><br>
                    <span class="dropzone-title">Upload Image</span>
                    <span class="dropzone-info">Drag and drop image or click to select.</span>
                </div>
                <div class="dropzone-text" v-else>
                    <span class="dropzone-title">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br>
                        <span class="dropzone-info">Uploading image ...</span>
                    </span>
                </div>

                <input type="file" @change="onFileChange">
            </div>
        </div>
        <div class="dropzone-preview" v-else>
            <img :src="remoteFilePath"  class="img-fluid" />
            <button class="btn btn-danger btn-sm" @click="removeImage" ><span class="fa fa-trash"></span> Remove Image</button>
        </div>
        <input type="hidden" v-model="remoteFileName">
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                required: true
            },
            basePath: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                image: '',
                remoteFilePath: '',
                remoteFileName: '',
                fileObject: false,
                hovering: false,
                uploading: false,
                error: false
            }
        },
        mounted() {
            this.remoteFilePath = this.basePath + this.value;
            this.remoteFileName = this.value;
        },
        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                this.fileObject = files[0];
                this.createImage();
            },
            createImage() {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                    vm.hovering = false;

                    vm.uploadFile();
                };
                reader.readAsDataURL(this.fileObject);
            },
            removeImage: function (e) {
                this.image = '';
                this.remoteFilePath = '';
                this.remoteFileName = '';
                this.fileObject = false;
                this.hovering = false;
                this.uploading = false;
                this.error = false;

                this.$emit('input', '');

            },
            uploadFile: function() {
                var self = this;
                this.uploading = true;
                this.uploadDone = false;

                var data = new FormData();
                data.append('file', this.fileObject);

                this.$http.post('/upload', data).then((response) => {
                    self.uploading = false;
                    self.uploadDone = true;
                    self.remoteFilePath = response.data.path;
                    self.remoteFileName = response.data.file;
                    self.error = false;

                    self.$emit('input', response.data.file);
                }, (response) => {
                    self.removeImage();
                    self.uploading = false;
                    self.uploadDone = false;
                    self.error = (response.data.file) ? response.data.file[0] : 'An unknown error occured. (' + response.status + ')';
                });

            }
        }
    };
</script>



<style lang="sass">
    .dropzone-area {
        width: 100%;
        height: 200px;
        position: relative;
        border: 2px dashed #eee;
        background-color: #f9f9f9;
        transition: all 0.5s;
        &:hover, &.dropzone-hover {
            border: 2px dashed #666666;
            .dropzone-title {
                color: #333;
            }
        }
    }

    .dropzone-area input {
        position: absolute;
        cursor: pointer;
        top: 0px;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
    }

    .dropzone-text {
        position: absolute;
        top: 50%;
        text-align: center;
        transform: translate(0, -50%);
        width: 100%;
        span {
            display: block;
        }

        .fa-spinner {
            margin-bottom: 10px;
        }
        .dropzone-icon {
            margin-bottom: 10px;
            color: #999;
        }
        .dropzone-title {
            font-weight: bold;
            font-size: 16px;
        }
        .dropzone-info {
            font-weight: normal;
            color: #999;
        }
    }

    .dropzone-close.modal-close {
        position: absolute;
        top: 10px;
        left: 10px;
        visibility: hidden;
        transform: inherit;
        transition: all 0.5s;
        &:hover span {
            background-color: red;
        }
    }

    .dropzone-background {
        position: absolute;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        opacity: 0.1;
        // filter: grayscale(100%);
    }

    .dropzone-preview {
        position: relative;
		margin-bottom: 40px;
        &:hover .dropzone-close.modal-close {
            visibility: visible;
        }
        img {
            border: 1px solid #ddd;
            border-radius: 1px;
            padding: 5px;
        }
        .btn {
            position: absolute;
            top: 100%;
            left: 0px;
			margin-top: 10px;
        }
    }
</style>
