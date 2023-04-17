<template>
    <div>
        <a-card>
            <a-tabs>
                <a-tab-pane key="1" tab="Campaign"> <input-box ref="inputBox" :langData="data" :showSubmit="true"
                        :missions="missions" :categories="categories" :type="'VI'" :campainId="id"/></a-tab-pane>
                <!-- <a-tab-pane key="2" tab="Tab 2"> <input-box ref="inputBox" :langData="data" :showSubmit="true"
                        :missions="missions" :categories="categories" :type="'CN'" /></a-tab-pane>
                <a-tab-pane key="3" tab="Tab 3"><input-box ref="inputBox" :langData="data" :showSubmit="true"
                        :missions="missions" :categories="categories" :type="'EN'" /></a-tab-pane> -->
            </a-tabs>
        </a-card>
    </div>
</template>

<script>


import inputBox from "@/pages/campaigns/new/inputbox.vue";
import { request } from "@/utils/request";
import _ from "lodash";

export default {
    name: "BasicForm",
    components: { inputBox },
    i18n: require("./i18n"),
   
    data() {
        const tabList = [
            {
                key: '1',
                tab: 'VN'
            },
            // {
            //     key: '2',
            //     tab: 'CN'
            // },
            // {
            //     key: '3',
            //     tab: 'US'
            // }
        ];
        const activeTabKey = '1';
        const noTitleKey = 'app';
        const data = {}

        return {
            tabList,
            activeTabKey,
            noTitleKey,
            data,
            categories: [],
            missions: [],
            id: this.$router.history.current.query.id || null
        };
    },

    methods: {
        getData() {
            if (this.id) {
                request(process.env.VUE_APP_API_BASE_URL + "/campain/" + this.id, "get").then((res) => {
                    const data = res?.data?.item ?? {};
                    this.data = {
                        ...data,
                        name: JSON.parse(data.name),
                        description: JSON.parse(data.description),
                        image: JSON.parse(data.image),
                        short_content: JSON.parse(data.short_content),
                        task: JSON.parse(data.list_task),
                        publicDate: data.date_public,
                        mission: data.mission_id,
                        imageLink: data.image
                    }
                });
            }
            request(process.env.VUE_APP_API_BASE_URL + "/campain/get-info-create", "get").then((res) => {
                const { categories, missions } = res?.data?.data ?? {};
                console.log({
                    categories,
                    missions
                })
                this.categories = _.map(categories, (item, key) => {
                    return {
                        label: item,
                        value: key
                    }
                });
                this.missions = _.map(missions, (item, key) => {
                    return {
                        label: item,
                        value: key
                    }
                });
            });
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
