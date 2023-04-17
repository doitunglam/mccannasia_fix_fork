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
            <input-box ref="inputBox" :langData="data" :showSubmit="true" :type="'VI'"/>
        </a-card>




    </div>



</template>

<script>


import inputBox from "@/pages/agency/edit/inputbox.vue";

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

    const data =
      {
          "id" : 1,
          "name" : "Supper Admin",
          "email" : "admin@gmail.com",
          "email_verified_at" : null,
          "password" : "$2y$10$HI0cA/3UHAlQOBy/CYUIiOxr4OLoUGrykgxZhYMLEZNlIwOt7Ng/S",
          "remember_token" : null,
          "status" : null,
          "type" : "super-admin",
          "amount" : 34700000,
          "image" : "upload/user/1/1678354562.jpg",
          "campains" : "[\"1\",\"96\"]",
          "created_at" : "2023-02-08 06:57:08",
          "updated_at" : "2023-04-12 21:26:44",
          "phone" : "0985895640",
          "address" : "123321",
          "close_account" : null,
          "url" : null,
          "bank_account" : "221",
          "bank_name" : "Agribank, VBARD",
          "bank_name_account" : "123",
          "gender" : "Female",
          "is_beginner" : 1,
          "referral_code" : null,
          "parent_referral_code" : null,
          "last_login_time" : "2023-04-12 21:26:44",
          "last_login_ip" : "127.0.0.1"
      }


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
