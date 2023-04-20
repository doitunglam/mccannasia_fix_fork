<template>
    <div>
        <a-button type="primary" @click="showModal">Open Modal</a-button>
        <a-modal @cancel="handleCancel" :visible="visible" title="Basic Modal" @ok="handleOk">
            <a-form @submit="handleSubmit" :form="form" class="form">
                <a-row class="form-row">


                    <a-col :lg="24" :md="24" :sm="24">

                        <a-form-item>
                            <a-row class="form-row">
                                <a-col :lg="24" :md="24" :sm="24">
                                    <a-form-item :label="$t('contractPrice')">
                                        <a-input
                                                :value="data.name"
                                                :placeholder="$ta('input|contractPrice')" @change="onChanged"
                                        />
                                    </a-form-item>
                                </a-col>
                                <a-col :lg="24" :md="24" :sm="24">
                                    <a-form-item :label="$t('revenueDay')">
                                        <a-input
                                                :value="data.name"
                                                :placeholder="$ta('input|revenueDay')" @change="onChanged"
                                        />
                                    </a-form-item>
                                </a-col>
                                <a-col :lg="24" :md="24" :sm="24">
                                    <a-form-item :label="$t('contractEndDate')">
                                        <a-input
                                                :value="data.name"
                                                :placeholder="$ta('input|contractEndDate')" @change="onChanged"
                                        />
                                    </a-form-item>
                                </a-col>
                                <a-col :lg="24" :md="24" :sm="24">
                                    <a-form-item :label="$t('name')">
                                        <a-input
                                                :value="data.name"
                                                :placeholder="$ta('input|name')" @change="onChanged"
                                        />
                                    </a-form-item>
                                </a-col>


                            </a-row>

                        </a-form-item>
                    </a-col>


                </a-row>


            </a-form>
        </a-modal>
    </div>
</template>
<script>


export default {
    name: 'Modal',
    components: {},

    data() {
        const data = {
            "id": 2,
            "name": "English",
            "code": "en",
            "image": "/upload/images/files/download%20(1).png",
            "value": "{\"All.language\":\"Language\",\"All.save\":\"Save\",\"All.name\":\"Name\",\"All.image\":\"Image\",\"All.code\":\"Code\",\"All.category_new\":\"Category New\",\"All.blog\":\"Blog\",\"All.campain\":\"Campain\",\"All.agency\":\"Agency\",\"All.payment\":\"Payment\",\"All.list\":\"List\",\"All.create\":\"Create\",\"All.new\":\"New\",\"All.edit\":\"Edit\",\"All.delete\":\"Delete\"}",
            "page_value": "{\"All\":{\"All.language\":\"Language\",\"All.save\":\"Save\",\"All.name\":\"Name\",\"All.image\":\"Image\",\"All.code\":\"Code\",\"All.category_new\":\"Category New\",\"All.blog\":\"Blog\",\"All.campain\":\"Campain\",\"All.agency\":\"Agency\",\"All.payment\":\"Payment\",\"All.list\":\"List\",\"All.create\":\"Create\",\"All.new\":\"New\",\"All.edit\":\"Edit\",\"All.delete\":\"Delete\"}}",
            "status": null,
            "created_at": "2023-02-14 22:10:59",
            "updated_at": "2023-03-03 14:07:10",
            "test": ""
        };

        return {
            value: data,
            data: data,
            visible: false,
            logging: false,
            error: '',
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
        showModal() {
            this.visible = true;
        },

        handleCancel(e) {
            console.log(e);
            this.visible = false;
        },

        handleOk(e) {
            console.log(e);

            console.log(this.value);
            console.log(this.data);
            this.visible = false;
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
