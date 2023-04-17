<template>
    <div>
        <a-card>
            <input-box ref="inputBox" :langData="data" :showSubmit="true" :type="'VN'"/>

        </a-card>




    </div>



</template>

<script>


import inputBox from "@/pages/campaignMission/edit/inputbox.vue";

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
