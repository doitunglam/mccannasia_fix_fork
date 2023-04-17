<template>
    <div>
        <a-card>
            <a-tabs >
                <a-tab-pane key="1" tab="Tab 1" > <input-box ref="inputBox" :langData="data" :showSubmit="true" :type="'VI'"/></a-tab-pane>
                <a-tab-pane key="2" tab="Tab 2" > <input-box  ref="inputBox" :langData="data" :showSubmit="true" :type="'CN'" /></a-tab-pane>
                <a-tab-pane key="3" tab="Tab 3"><input-box   ref="inputBox" :langData="data" :showSubmit="true" :type="'EN'" /></a-tab-pane>

            </a-tabs>
        </a-card>




    </div>



</template>

<script>


import inputBox from "@/pages/campaigns/new/inputbox.vue";


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

        console.log(activeTabKey)

        const data = {
            "id": 96,
            "name": "McCann Asia",
            "description": "McCann Asia là một nền tảng trung gian kết nối các công ty thương mại và dịch vụ trực tuyến về thương mại điện tử, bán lẻ, ngân hàng và tài chính…và đặt chỗ trực tuyến vơi các đối tác phương tiện truyền thông để quảng bá sản phẩm đến người dùng.\nMcCann Asia là nền tảng quảng cáo lớn và uy tín nhất Châu Á với hơn 2.000.000 thành viên và hàng trăm chiến dịch tham gia.",
            "reson_cancel": "Không đáp ứng đủ các điều kiện ghi nhận kết quả được tính hoa hồng.\nKhông thực hiện nhiệm vụ 3 ngày liên tiếp, và dưới 25 ngày trong 1 tháng\nDùng tài khoản facebook, zalo không chính chủ( acc clone, tạo mới)\nNếu phát hiện Publisher có hành vi gian lận, tạo nhiều tài khoản, hoặc vi phạm các quy định về chạy quảng cáo thì sẽ bị ngưng quyền chạy chiến dịch ngay lập tức \nPublisher vẫn sẽ được hoàn lại phí ràng buộc hợp đồng ban đầu",
            "short_content": "McCann Asia là một nền tảng trung gian kết nối các công ty thương mại và dịch vụ trực tuyến về thương mại điện tử, bán lẻ, ngân hàng và tài chính…và đặt chỗ trực tuyến vơi các đối tác phương tiện truyền thông để quảng bá sản phẩm đến người dùng.\nMcCann Asia là nền tảng quảng cáo lớn và uy tín nhất Châu Á với hơn 2.000.000 thành viên và hàng trăm chiến dịch tham gia.",
            "link_": null,
            "image": null,
            "list_task": "{\"en\":[null,\"3\"],\"vi\":[null,null],\"cn\":[null,null]}",
            "date_public": null,
            "date_end": null,
            "price_day": null,
            "registration_fee": 2000000,
            "code": null,
            "price": 70000,
            "status": null,
            "users": "[3,1]",
            "created_at": "2023-03-03 14:54:30",
            "updated_at": "2023-03-10 11:13:36",
            "category": 6,
            "mission_id": null,
            "is_hot": 0,
            "is_beginner": 0,
            "campain_category": null,
        };

        return {
            tabList,


            activeTabKey,
            noTitleKey,

            data,
        };
    },

    methods: {
        onTabChange(value, type) {
            console.log(value, type);
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
};
</script>

<style lang="less" scoped>
.card{
    margin-bottom: 24px;
}
</style>
