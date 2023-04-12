<template>
  <div class="image-input">
    <a-upload
      :file-list="fileList"
      name="file"
      action="https://www.mocky.io/v2/5cc8019d300000980a055e76"
      :headers="headers"
      @change="handleChange"
    >
      <a-button>
        <a-icon type="upload" />
        Click to Upload
      </a-button>
    </a-upload>
  </div>
</template>
<script>
import { message } from "ant-design-vue";
import { defineComponent, ref } from "vue";
export default defineComponent({
     name: 'ImageInput',
  setup() {
    const handleChange = (info) => {
      if (info.file.status !== "uploading") {
        console.log(info.file, info.fileList);
      }
      if (info.file.status === "done") {
        message.success(`${info.file.name} file uploaded successfully`);
      } else if (info.file.status === "error") {
        message.error(`${info.file.name} file upload failed.`);
      }
    };
    const fileList = ref([]);
    return {
      fileList,
      handleChange,
    };
  },
});
</script>
