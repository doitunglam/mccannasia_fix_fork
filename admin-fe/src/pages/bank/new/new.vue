<template>
    <a-card :body-style="{ padding: '24px 32px' }" :bordered="false">
        <a-form>
            <a-form-item :label="$t('name')" :labelCol="{ span: 7 }" :wrapperCol="{ span: 10 }">
                <a-input
                        :placeholder="$t('nameInput')"
                        name="name"
                        :value="data.name"
                        @change="setNestedProperty"
                />
            </a-form-item>

            <a-form-item
                    :label="$t('bankName')"
                    :labelCol="{ span: 7 }"
                    :wrapperCol="{ span: 10 }"
            >
            <a-input
                        :placeholder="$t('bankName')"
                        name="bank"
                        :value="data.bank"
                        @change="setNestedProperty"
                />
            </a-form-item>

            <a-form-item
                    :label="$t('bankAccount')"
                    :labelCol="{ span: 7 }"
                    :wrapperCol="{ span: 10 }"
            >
                <a-input
                        :placeholder="$t('bankAccountInput')"
                        :value="data.value"
                        @change="onChanged"
                        :name="'value'"
                />
            </a-form-item>

            <a-form-item
                    :label="$t('image')"
                    :labelCol="{ span: 7 }"
                    :wrapperCol="{ span: 10 }"
            >
                <a-input
                        :placeholder="$t('image')"
                        :value="data.image"
                        @change="onChanged"
                        :name="'value'"
                />
            </a-form-item>

            <a-form-item style="margin-top: 24px" :wrapperCol="{ span: 10, offset: 7 }">
                <a-button style="margin-left: 8px" @click="send">{{ $t("save") }}</a-button>
            </a-form-item>
        </a-form>
    </a-card>
</template>

<script>
import { request, METHOD } from "@/utils/request";

export default {
    name: "BasicForm",
    i18n: require("./i18n"),
    data() {
        const data = {};
        return {
            data,
            id: this.$router.history.current.query.id || null
        };
    },
    methods: {
        send() {
            const data = {
                ...this.data,
                name: {
                    bank: this.data.bank,
                    name: this.data.name,
                }
            }
            if(this.id) {
                data.id = this.id
            }
            request(
                process.env.VUE_APP_API_BASE_URL + '/bank',
                METHOD.POST,
                data).then(() => {
                    this.data = {}
                    this.$message.success(`Update successfully`);
                })
        },
        getData() {
            if (this.id) {
                request(process.env.VUE_APP_API_BASE_URL + "/bank/" + this.id, "get").then((res) => {
                    const data = res?.data?.item ?? {};
                    const info = JSON.parse(data.name);
                    this.data = {
                        ...data,
                        bank: info.bank,
                        name: info.name,
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
