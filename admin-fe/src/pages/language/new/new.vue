<template>
    <div>
        <a-card class="card"  :bordered="false">
            <a-form>
                <a-form-item :label="$t('name')" :labelCol="{ span: 7 }" :wrapperCol="{ span: 10 }">
                    <a-input
                            :placeholder="$t('nameInput')"
                            name="name"
                            :value="data.name"
                            @change="onChanged"
                    />
                </a-form-item>
                <a-form-item
                        :label="$t('codeInput')"
                        :labelCol="{ span: 7 }"
                        :wrapperCol="{ span: 10 }"
                >
                    <a-input
                            :placeholder="$t('codeInput')"
                            :value="data.code"
                            @change="onChanged"
                            :name="'code'"
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
        <a-card class="card" :title="$t('pageAll')" :bordered="false">
            <page-all ref="pageAll" :langData="data" :showSubmit="true" />
        </a-card>
        <a-card class="card" :title="$t('languageAll')" :bordered="false">
            <langauge-all ref="langaugeAll" :langData="data" :showSubmit="true" />

        </a-card>


    </div>



</template>

<script>
import langaugeAll from "@/pages/language/new/languageAll.vue";
import pageAll from "@/pages/language/new/pageAll.vue";


export default {
  name: "BasicForm",
    components: {langaugeAll, pageAll},
  i18n: require("./i18n"),
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
    const value = JSON.parse(data.value);
    const page_value = JSON.parse(data.page_value);
    return {
      data,
        value,
        page_value,
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

<style lang="less" scoped>
.card{
    margin-bottom: 24px;
}
</style>
