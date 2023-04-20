<template>
    <a-card :body-style="{ padding: '24px 32px' }" :bordered="false">
        <a-form>
            <a-form-item :label="$t('link')" :labelCol="{ span: 7 }" :wrapperCol="{ span: 10 }">
                <a-input :value="data.link_" @change="onChanged" name="link_" />
            </a-form-item>

            <a-form-item :label="$t('image')" :labelCol="{ span: 7 }" :wrapperCol="{ span: 10 }">
                <a-upload name="avatar" list-type="picture-card" class="avatar-uploader" :show-upload-list="false"
                    :before-upload="beforeUpload" :custom-request="dummyRequest">
                    <img v-if="data.image" :src="data.image" alt="avatar" />
                    <div v-else>
                        <a-icon :type="loading ? 'loading' : 'plus'" />
                        <div class="ant-upload-text">
                            Upload
                        </div>
                    </div>
                </a-upload>
                <!-- <a-input :placeholder="$t('image')" :value="data.image" @change="onChanged" :name="'value'" type /> -->
            </a-form-item>
            <a-form-item style="margin-top: 24px" :wrapperCol="{ span: 10, offset: 7 }">
                <a-button style="margin-left: 8px" @click="send">{{ $t("save") }}</a-button>
            </a-form-item>
        </a-form>
    </a-card>
</template>

<script>
import { request, METHOD } from "@/utils/request";
function getBase64(img, callback) {
    const reader = new FileReader();
    reader.addEventListener('load', () => callback(reader.result));
    reader.readAsDataURL(img);
}
export default {
    name: "BasicForm",
    i18n: require("./i18n"),
    data() {
        const data = { image: "" };
        return {
            data,
            id: this.$router.history.current.query.id || null,
            apiImgUpload: process.env.VUE_APP_API_BASE_URL + "/image",
        };
    },
    methods: {
        send() {
            const data = {
                name: this.data.link_,
                image: "/upload" + this.data.image.split("/upload")[1],
                is_popup: 1
            }
            if (this.id) {
                data.id = this.id
            }
            request(
                process.env.VUE_APP_API_BASE_URL + '/popup',
                METHOD.POST,
                data).then(() => {
                    this.data = {}
                    this.$message.success(`Update successfully`);
                })
        },
        handleChange(info) {
            if (info.file.status === 'uploading') {
                this.loading = true;
                return;
            }
            if (info.file.status === 'done') {
                // Get this url from response in real world.
                getBase64(info.file.originFileObj, imageUrl => {
                    this.imageUrl = imageUrl;
                    this.loading = false;
                });
            }
        },
        dummyRequest({ file, onSuccess }) {
            const formData = new FormData();
            formData.append('image', file);
            request(this.apiImgUpload, METHOD.POST, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                this.data.image = process.env.VUE_APP_API_BASE_URL.replace('/api', "/upload/images/files/") + res.data.image_path;
                onSuccess("ok");
            });
        },
        beforeUpload(file) {
            const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
            if (!isJpgOrPng) {
                this.$message.error('You can only upload JPG file!');
            }
            const isLt2M = file.size / 1024 / 1024 < 100;
            if (!isLt2M) {
                this.$message.error('Image must smaller than 2MB!');
            }
            return isJpgOrPng && isLt2M;
        },
        getData() {
            if (this.id) {
                request(process.env.VUE_APP_API_BASE_URL + "/popup/" + this.id, "get").then((res) => {
                    const data = res?.data?.item ?? {};
                    this.data = {
                        ...data,
                        _link: data.name,
                        image: process.env.VUE_APP_API_BASE_URL.replace('/api', "") + data.image,
                    }
                });
            }
        },
        setNestedProperty(event) {
            // Split the property path by dots to get an array of property names
            const properties = event.target.name.split(".");

            // Loop through the properties to access the nested property
            let nestedObj = this.data;
            for (let i = 0; i < properties.length - 1; i++) {
                const property = properties[i];
                nestedObj = nestedObj[property];
            }

            // Set the value of the final property
            nestedObj[properties[properties.length - 1]] = event.target.value;
        },
        setNestedPropertySelect(event, op) {
            // Split the property path by dots to get an array of property names
            const properties = op.data.attrs.dropdownClassName.split(".");

            // Loop through the properties to access the nested property
            let nestedObj = this.data;
            for (let i = 0; i < properties.length - 1; i++) {
                const property = properties[i];
                nestedObj = nestedObj[property];
            }

            // Set the value of the final property
            nestedObj[properties[properties.length - 1]] = event;
        },

        onChanged(event) {
            console.log(event);
            const fieldName = event.target.name;
            const value = event.target.value;
            this.data[fieldName] = value;
        },
        onChangedSelect(event, op) {
            console.log(event);
            console.log(op);
            const fieldName = op.data.attrs.dropdownClassName;
            const value = event;
            this.data[fieldName] = value;
        },
    },

    computed: {
        desc() {
            return this.$t("pageDesc");
        },
    },
    mounted() {
        this.getData();
    },
};
</script>

<style scoped></style>
