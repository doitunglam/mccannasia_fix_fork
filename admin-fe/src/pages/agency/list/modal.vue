<template>
    <div>
        <a-modal :closable="false" :visible="showModal" :title="$t('modalTitle')">
            <a-form @submit="handleSubmit" :form="form" class="form">
                <a-row class="form-row">
                    <a-col :lg="24" :md="24" :sm="24">
                        <a-form-item>
                            <a-row class="form-row">
                                <a-col :lg="24" :md="24" :sm="24">
                                    <a-form-item :label="$t('type')">
                                        <!-- Create radio to choose increase or decrease amount -->
                                        <a-radio-group v-model="data.type" name="type">
                                            <a-radio-button value="increase">{{ $t('increase') }}</a-radio-button>
                                            <a-radio-button value="decrease">{{ $t('decrease') }}</a-radio-button>
                                        </a-radio-group>
                                    </a-form-item>
                                </a-col>
                                <a-col :lg="24" :md="24" :sm="24">
                                    <a-form-item :label="$t('amount')">
                                        <a-input v-model="data.amount" type="number" name="amount"
                                            :placeholder="$ta('amount')" @change="onChanged" />
                                    </a-form-item>
                                </a-col>
                            </a-row>
                        </a-form-item>
                    </a-col>
                </a-row>
            </a-form>
            <template #footer>
                <a-button key="back" @click="handleCancel">{{ $ta('cancel') }}</a-button>
                <a-button key="submit" type="primary" @click="handleOk">Ok</a-button>
            </template>
        </a-modal>
    </div>
</template>
<script>
import { request, METHOD } from "@/utils/request";

export default {
    name: 'Modal',
    components: {},
    props: ['showModal', 'id', 'currentAmount'],
    i18n: require("./i18n"),
    data() {
        const data = {
            type: 'increase',
            amount: 0,
        };
        return {
            data: data,
            form: this.$form.createForm(this)
        }
    },
    computed: {
        systemName() {
            return this.$store.state.setting.systemName
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
            if (this.data.amount < 0) {
                this.$message.error("Amount must be greater than 0");
                return;
            }
            if (this.data.amount > this.currentAmount && this.data.type == 'decrease') {
                this.$message.error("Amount must be less than current amount");
                return;
            }
            if (this.data.amount > 0) {
                const confirm = window.confirm("Are you sure?");
                if (!confirm) {
                    return;
                }
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
