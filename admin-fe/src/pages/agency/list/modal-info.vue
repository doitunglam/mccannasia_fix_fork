<template>
    <div key="2">
        <a-modal :visible="showModal" :title="$t('modalTitle')">
            <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                <a-range-picker :style="{ width: '256px' }" v-model="myCustomDate"></a-range-picker>
            </div>
            <ranking-list :list="info" />
            <template #footer>
                <a-button key="back" @click="handleCancel">{{ $ta('close') }}</a-button>
            </template>
        </a-modal>
    </div>
</template>
<script>
import { request, METHOD } from "@/utils/request";
import RankingList from '../../../components/chart/RankingList'
import { formatCurrencyVND } from "@/utils/util";
export default {
    name: 'ModalInfo',
    components: { RankingList },
    props: ['showModal', 'idSelected2',],
    i18n: require("./i18n"),
    data() {

        return {
            data: {},
            info: [],
            form: this.$form.createForm(this),
            myCustomDate: [null, null],
            from: null,
            to: null,
        }
    },
    watch: {
        idSelected2: {
            handler: function (val) {
                this.idSelected2 = val;
                this.getData();
            },
            deep: true
        },
        myCustomDate: function (val) {
            if (val[0] && val[1]) {
                this.from = val[0].toISOString()
                this.to = val[1].toISOString()
                this.getData()
            }
        },
    },
    computed: {
        systemName() {
            return this.$store.state.setting.systemName
        }
    },
    methods: {
        getData() {
            let uri = process.env.VUE_APP_API_BASE_URL + "/agency/info/" + this.idSelected2
            if (this.from && this.to) {
                uri += "?from=" + this.from + "&to=" + this.to
            }
            request(uri, "get", {
            }).then((res) => {
                const { data } = res?.data ?? {};

                this.info = Object.keys(data).map((key) => {
                    const value = formatCurrencyVND(data[key] || 0);
                    return {
                        name: key,
                        total: key !== "Total Agency" ? value : data[key] || 0
                    }
                });
            });
        },
        handleSubmit(e) {
            e.preventDefault()
            this.form.validateFields((err, values) => {
                if (!err) {
                    console.log('Received values of form: ', values)
                }
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

        handleCancel() {
            this.$emit('update:showModal', false);
        },

        handleOk() {
            if (this.data.amount > 0) {
                request(process.env.VUE_APP_API_BASE_URL + "/agency/change-amount/" + this.id, METHOD.PUT, {
                    amount: this.data.amount,
                    type: this.data.type
                }).then(() => {
                    this.$emit('update:showModal', false);
                    this.$message.success("Change amount success");
                });
            }
        },


    }
}
</script>

<style lang="less" scoped>
.common-layout {
    .top {
        text-align: center;

        .header {
            height: 44px;
            line-height: 44px;

            a {
                text-decoration: none;
            }

            .logo {
                height: 44px;
                vertical-align: top;
                margin-right: 16px;
            }

            .title {
                font-size: 33px;
                color: @title-color;
                font-family: 'Myriad Pro', 'Helvetica Neue', Arial, Helvetica, sans-serif;
                font-weight: 600;
                position: relative;
                top: 2px;
            }
        }

        .desc {
            font-size: 14px;
            color: @text-color-second;
            margin-top: 12px;
            margin-bottom: 40px;
        }
    }

    .login {
        width: 368px;
        margin: 0 auto;

        @media screen and (max-width: 576px) {
            width: 95%;
        }

        @media screen and (max-width: 320px) {
            .captcha-button {
                font-size: 14px;
            }
        }

        .icon {
            font-size: 24px;
            color: @text-color-second;
            margin-left: 16px;
            vertical-align: middle;
            cursor: pointer;
            transition: color 0.3s;

            &:hover {
                color: @primary-color;
            }
        }
    }
}
</style>
