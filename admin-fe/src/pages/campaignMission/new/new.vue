<script src="i18n-inputBox.js"></script>
<template>
    <div>
        <a-card>
            <input-box ref="inputBox" :langData="data" :showSubmit="true" :type="'VN'"/>
        </a-card>
    </div>
</template>

<script>
import inputBox from "@/pages/campaignMission/new/inputbox.vue";
import { request } from "@/utils/request";

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
        const data = {
        };
        return {
            tabList,
            data,
            activeTabKey: '1',
            id: this.$router.history.current.query.id || null
        };
    },
    methods: {
        getData() {
            if (this.id) {
                console.log("Handler")
                request(process.env.VUE_APP_API_BASE_URL + "/campain-mission/" + this.id, "get").then((res) => {
                    const data = res?.data?.item ?? {};
                    this.data = {
                        ...data,
                    }
                });
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
.card{
    margin-bottom: 24px;
}
</style>
