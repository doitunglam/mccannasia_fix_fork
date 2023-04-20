<script src="i18n-inputBox.js"></script>
<template>
    <div>
        <!--        <a-card class="card"  :bordered="false">-->
        <!--            <a-form>-->
        <!--                <a-form-item :label="$t('name')" :labelCol="{ span: 7 }" :wrapperCol="{ span: 10 }">-->
        <!--                    <a-input-->
        <!--                            :placeholder="$t('nameInput')"-->
        <!--                            name="name"-->
        <!--                            :value="data.name"-->
        <!--                            @change="onChanged"-->
        <!--                    />-->
        <!--                </a-form-item>-->
        <!--                <a-form-item-->
        <!--                        :label="$t('codeInput')"-->
        <!--                        :labelCol="{ span: 7 }"-->
        <!--                        :wrapperCol="{ span: 10 }"-->
        <!--                >-->
        <!--                    <a-input-->
        <!--                            :placeholder="$t('codeInput')"-->
        <!--                            :value="data.code"-->
        <!--                            @change="onChanged"-->
        <!--                            :name="'code'"-->
        <!--                    />-->
        <!--                </a-form-item>-->

        <!--                <a-form-item-->
        <!--                        :label="$t('image')"-->
        <!--                        :labelCol="{ span: 7 }"-->
        <!--                        :wrapperCol="{ span: 10 }"-->
        <!--                >-->
        <!--                </a-form-item>-->

        <!--                <a-form-item style="margin-top: 24px" :wrapperCol="{ span: 10, offset: 7 }">-->
        <!--                    <a-button style="margin-left: 8px" @click="send">{{ $t("save") }}</a-button>-->
        <!--                </a-form-item>-->
        <!--            </a-form>-->
        <!--        </a-card>-->

        <!--        <a-card-->
        <!--            style="margin-top: 24px"-->
        <!--            :bordered="false"-->
        <!--            :tabList="tabList"-->
        <!--            :activeTabKey="activeTabKey.value"-->
        <!--            @tabChange="key => onTabChange(key, 'key')"-->
        <!--        >-->

        <!--            <input-box  v-if="activeTabKey.value === '1'" ref="inputBox" :langData="data" :showSubmit="true" :type="'VI'"/>-->
        <!--            <input-box  v-else-if="activeTabKey.value === '2'" ref="inputBox" :langData="data" :showSubmit="true" :type="'CN'" />-->
        <!--            <input-box  v-else-if="activeTabKey.value === '3'" ref="inputBox" :langData="data" :showSubmit="true" :type="'EN'" />-->


        <!--        </a-card>-->
        <a-card>
            <input-box ref="inputBox" :langData="data" :showSubmit="true" :agencyId="id" :type="'VI'" />
        </a-card>




    </div>
</template>

<script>


import inputBox from "@/pages/agency/new/inputbox.vue";
import {request} from "@/utils/request";
export default {
    name: "BasicForm",
    components: {inputBox},
    i18n: require("./i18n"),
    data() {
        const tabList = [
            {
                key: '1',
                tab: 'VN'
            },
            {
                key: '2',
                tab: 'CN'
            },
            {
                key: '3',
                tab: 'US'
            }
        ];
        const activeTabKey = '1';
        const noTitleKey = 'app';


        const data = {        }
        return {
            tabList,
            activeTabKey,
            noTitleKey,
            data,
            id: this.$router.history.current.query.id || null
        };
    },

    methods: {
        getData() {
            console.log(this.id)
            if (this.id) {
                request(process.env.VUE_APP_API_BASE_URL + "/agency/" + this.id, "get").then((res) => {
                    const data = res?.data?.item ?? {};
                    this.data = {
                        ...data,
                    }
                });
            }
        },
        onTabChange(value, type) {
            if (type === 'key') {
                this.activeTabKey.value = value;
            } else if (type === 'noTitleKey') {
                this.noTitleKey.value = value;
            }
        },
        send() {
            console.log(this.data);
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

<style lang="less" scoped>
.card {
    margin-bottom: 24px;
}
</style>
