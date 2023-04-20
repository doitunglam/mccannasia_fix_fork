<template>
  <a-card :body-style="{ padding: '24px 32px' }" :bordered="false">
    <a-form>
      <a-form-item :label="$t('name')" :labelCol="{ span: 7 }" :wrapperCol="{ span: 10 }">
        <a-input
          :placeholder="$t('nameInput')"
          name="name.name"
          :value="data.name.name"
          @change="setNestedProperty"
        />
      </a-form-item>

      <a-form-item
        :label="$t('bankName')"
        :labelCol="{ span: 7 }"
        :wrapperCol="{ span: 10 }"
      >
        <a-select
          :placeholder="$t('bankNameSelect')"
          dropdownClassName="name.bank"
          :value="data.name.bank"
          @change="setNestedPropertySelect"
          v-decorator="[
            'repository.manager',
            { rules: [{ required: true, message: $t('bankNameSelect') }] },
          ]"
        >
          <a-select-option
            dropdownClassName="name.bank"
            v-for="(item, index) in bankNameList"
            :value="item"
            :key="index"
            >{{ item }}</a-select-option
          >
        </a-select>
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
      </a-form-item>

      <a-form-item style="margin-top: 24px" :wrapperCol="{ span: 10, offset: 7 }">
        <a-button style="margin-left: 8px" @click="send">{{ $t("save") }}</a-button>
      </a-form-item>
    </a-form>
  </a-card>
</template>

<script>
export default {
  name: "BasicForm",
  i18n: require("./i18n"),
  data() {
      console.log(this.$route.query);
    const data = {
      id: 1,
      name: {
        name: "John Doe",
        bank: "Bank of America",
      },
      value: "ABC123DEF4",
      image: "https://picsum.photos/200/300",
      status: 1,
    };
    return {
      data,
    };
  },
  created() {
    this.bankNameList = [
      "Agribank",
      "BIDV - Bank for Investment and Development of Vietnam",
      "VietinBank - Vietnam Joint Stock Commercial Bank for Industry and Trade",
      "Vietcombank - Joint Stock Commercial Bank for Foreign Trade of Vietnam",
      "Sacombank - Saigon Thuong Tin Commercial Joint Stock Bank",
      "Techcombank - Vietnam Technological and Commercial Joint Stock Bank",
      "MBBank - Military Commercial Joint Stock Bank",
      "ACB - Asia Commercial Joint Stock Bank",
      "Viet Capital Bank",
      "VPBank - Vietnam Prosperity Joint Stock Commercial Bank",
      "TPBank - Tien Phong Commercial Joint Stock Bank",
      "Eximbank - Vietnam Export Import Commercial Joint Stock Bank",
      "SeABank - Southeast Asia Commercial Joint Stock Bank",
      "Vietbank - Vietnam Thuong Tin Commercial Joint Stock Bank",
      "OceanBank - Ocean Commercial Joint Stock Bank",
      "HDBank - Ho Chi Minh City Development Joint Stock Commercial Bank",
      "LienVietPostBank - Lien Viet Post Joint Stock Commercial Bank",
      "Bac A Bank - Bank for Foreign Trade of Vietnam",
      "GPBank - Global Petro Commercial Joint Stock Bank",
      "VietABank - Vietnam Asia Commercial Joint Stock Bank",
      "Orient Commercial Joint Stock Bank (OCB)",
      "PVcomBank - PetroVietnam Construction Joint Stock Commercial Bank",
      "Nam A Bank - Nam A Commercial Joint Stock Bank",
      "Saigonbank - Saigon Bank for Industry and Trade",
      "Viet Capital Commercial Joint Stock Bank",
    ];
  },
  methods: {
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

<style scoped></style>
