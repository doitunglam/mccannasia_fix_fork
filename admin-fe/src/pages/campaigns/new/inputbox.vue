<template>
    <a-form @submit="handleSubmit" :form="form" class="form">
        <a-row class="form-row">
            <a-col :lg="18" :md="18" :sm="24">

                <a-form-item>
                    <a-row class="form-row">
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('name')">
                                <a-input :value="data.name" :placeholder="$ta('name')" @change="onChanged" name="name" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('description')">
                                <a-textarea rows="4" :value="data.description" name="description"
                                    :placeholder="$ta('description')" @change="onChanged" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('shortContent')">
                                <a-input name="short_content" :value="data.short_content" :placeholder="$ta('shortContent')"
                                    @change="onChanged" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('publicDate')">
                                <a-input name="date_public" :value="data.publicDate" :placeholder="$ta('publicDate')"
                                    @change="onChanged" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('link')">
                                <a-input name="link_" :value="data.link_" :placeholder="$ta('link')" @change="onChanged" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('task')">
                                <a-input name="task" :value="data.task" :placeholder="$ta('task')" @change="onChanged" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('imageLink')">
                                <a-upload name="avatar" list-type="picture-card" class="avatar-uploader"
                                    :show-upload-list="false" :before-upload="beforeUpload" :custom-request="dummyRequest">
                                    <img v-if="data.imageLink" :src="data.imageLink" alt="avatar" />
                                    <div v-else>
                                        <a-icon :type="loading ? 'loading' : 'plus'" />
                                        <div class="ant-upload-text">
                                            Upload
                                        </div>
                                    </div>
                                </a-upload>
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('price')">
                                <a-input name="price" :value="data.price" :placeholder="$ta('price')" @change="onChanged" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('mission')">
                                <a-select name="mission_id" :placeholder="$ta('mission')" @change="onChangeMission"
                                    :value="data.mission">
                                    <a-select-option v-for="(item) in missions" :key="item.value" :value="item.value">
                                        {{ item.label }}
                                    </a-select-option>
                                </a-select>
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('category')">
                                <a-select name="category" :placeholder="$ta('category')" @change="onChangeCategory"
                                    :value="data.category">
                                    <a-select-option v-for="(item) in categories" :key="item.value" :value="item.value">
                                        {{ item.label }}
                                    </a-select-option>
                                </a-select>
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('isHot')">
                                <a-input name="is_hot" :value="data.isHot" :placeholder="$ta('isHot')" @change="onChanged"
                                    type="checkbox" />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item :label="$t('isBeginner')">
                                <a-input name="is_beginner" :value="data.isBeginner" :placeholder="$ta('isBeginner')"
                                    @change="onChanged" type="checkbox" />
                            </a-form-item>
                        </a-col>
                    </a-row>
                </a-form-item>
            </a-col>
        </a-row>
        <a-form-item v-if="showSubmit">
            <a-button htmlType="submit" @click="send">Submit</a-button>
        </a-form-item>
    </a-form>
</template>

<script>
import { METHOD, request } from '../../../utils/request';

export default {
    name: 'inputBox',
    props: ['showSubmit', "langData", "type", "categories", 'missions', "campainId"],
    i18n: require('./i18n-inputBox.js'),
    data() {
        const data = { ... this.langData };

        Object.keys(data).forEach(key => {
            if (this.isJson(data[key])) {

                data[key] = JSON.parse(data[key])
                console.log(this.type.toLowerCase())

                if (data[key][this.type.toLowerCase()]) {
                    data[key] = data[key][this.type.toLowerCase()]
                }
            }
        });
        return {
            data,
            apiImgUpload: process.env.VUE_APP_API_BASE_URL + "/image",
            form: this.$form.createForm(this)
        }
    },
    watch: {
        langData: {
            handler: function (val,) {
                this.data = { ...val };
                Object.keys(this.data).forEach(key => {
                    if (this.isJson(this.data[key])) {
                        this.data[key] = JSON.parse(this.data[key])
                        if (this.data[key][this.type.toLowerCase()]) {
                            this.data[key] = this.data[key][this.type.toLowerCase()]
                        }
                    }
                });
            },
            deep: true
        }
    },
    methods: {
        onChangeCategory(value) {
            this.data.category = value
        },
        onChangeMission(value) {
            this.data.mission = value
        },
        dummyRequest({ file, onSuccess }) {
            const formData = new FormData();
            formData.append('image', file);
            request(this.apiImgUpload, METHOD.POST, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                this.data.imageLink = process.env.VUE_APP_API_BASE_URL.replace('/api', "/upload/images/files/") + res.data.image_path;
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
        isJson(item) {
            let value = typeof item !== "string" ? JSON.stringify(item) : item;
            try {
                value = JSON.parse(value);
            } catch (e) {
                return false;
            }

            return typeof value === "object" && value !== null;
        },
        handleSubmit(e) {
            e.preventDefault()
            this.form.validateFields((err, values) => {
                if (!err) {
                    console.log('Received values of form: ', values)
                }
            })
        },
        send() {
            // return console.log(this.data)
            const data = {
                ...this.data,
                is_beginner: this.data.is_beginner,
                is_hot: this.data.is_hot,
                mission_id: this.data.mission,
                image: "/upload" + this.data.imageLink.split("/upload")[1],
                task: this.data.task,
                date_public: this.data.date_public,
            }
            if (this.campainId) {
                data.id = this.campainId
            }
            request(
                process.env.VUE_APP_API_BASE_URL + '/campain',
                METHOD.POST,
                data).then(() => {
                    this.data = {}
                    this.$message.success(`Update successfully`);
                })
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
        onChangedKey(event) {

            const _value = event.target.name;
            const newKeys = event.target.value;
            const oldKey = Object.keys(this.value).find(key => this.value[key] === _value);
            delete this.value[oldKey];
            this.value[newKeys] = _value;
        },
        onchangeValue(event) {

            const fieldName = event.target.name;
            const _value = event.target.value;
            this.value[fieldName] = _value;
        },
        onChangedSelect(event, op) {
            console.log(event);
            console.log(op);
            const fieldName = op.data.attrs.dropdownClassName;
            const value = event;
            this.data[fieldName] = value;
        },
    },
}
</script>

<style lang="less" scoped>
.form {
    .form-row {
        margin: 0 -8px
    }

    .ant-col-md-12,
    .ant-col-sm-24,
    .ant-col-lg-6,
    .ant-col-lg-8,
    .ant-col-lg-10,
    .ant-col-xl-8,
    .ant-col-xl-6 {
        padding: 0 8px
    }
}
</style>
