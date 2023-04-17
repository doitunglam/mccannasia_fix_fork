<template>
    <a-form @submit="handleSubmit" :form="form" class="form">
        <a-row class="form-row">
            <a-col :lg="16" :md="16" :sm="24">

                <a-form-item >
                    <a-row class="form-row">
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item  :label="$t('name')">
                                <a-input
                                    :value="data.name"
                                    @change="onChanged"
                                    name="name"
                                />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item  :label="$t('content')">
                                <a-textarea rows="4"
                                    :value="data.content"
                                    @change="onChanged"
                                    name="content"
                                />
                            </a-form-item>
                        </a-col>

                    </a-row>

                </a-form-item>
            </a-col>

            <a-col :lg="8" :md="8" :sm="24">

                <a-form-item >
                    <a-row class="form-row">
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item  :label="$t('contractPrice')">
                                <a-input
                                    :value="data.binding_fee"
                                    @change="onChanged"
                                    name="binding_fee"
                                />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item  :label="$t('revenueDay')">
                                <a-input
                                    :value="data.daily_profit"
                                    @change="onChanged"
                                    name="daily_profit"
                                />
                            </a-form-item>
                        </a-col>
                        <a-col :lg="24" :md="24" :sm="24">
                            <a-form-item  :label="$t('contractEndDate')">
                                <a-input
                                    :value="data.contract_term"
                                    @change="onChanged"
                                    name="contract_term"
                                />
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
    props: ['showSubmit', "langData", "type", "campainMissionId"],
    i18n: require('./i18n-inputBox.js'),
    data() {
        const data = this.langData;
        return {
            data,
            form: this.$form.createForm(this)
        }
    },
    watch: {
        langData: {
            handler: function (val) {
                this.data = val;
            },
            deep: true
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            this.form.validateFields((err, values) => {
                if (!err) {
                    console.log('Received values of form: ', values)
                }
            })
        },
        send() {
            const data = {
                ...this.data,
            }
            if(this.campainMissionId) {
                data.id = this.campainMissionId
            }
            request(
                process.env.VUE_APP_API_BASE_URL + '/campain-mission',
                METHOD.POST,
                data).then(res => {
                    console.log(res)
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
