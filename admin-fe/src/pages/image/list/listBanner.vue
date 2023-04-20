<template>
  <a-card>
    <!-- <div :class="advanced ? 'search' : null">
      <a-form layout="horizontal">
        <div :class="advanced ? null : 'fold'">
          <a-row>
            <a-col :md="8" :sm="24">
              <a-form-item
                label="规则编号"
                :labelCol="{ span: 5 }"
                :wrapperCol="{ span: 18, offset: 1 }"
              >
                <a-input placeholder="请输入" />
              </a-form-item>
            </a-col>
            <a-col :md="8" :sm="24">
              <a-form-item
                label="使用状态"
                :labelCol="{ span: 5 }"
                :wrapperCol="{ span: 18, offset: 1 }"
              >
                <a-select placeholder="请选择">
                  <a-select-option value="1">关闭</a-select-option>
                  <a-select-option value="2">运行中</a-select-option>
                </a-select>
              </a-form-item>
            </a-col>
            <a-col :md="8" :sm="24">
              <a-form-item
                label="调用次数"
                :labelCol="{ span: 5 }"
                :wrapperCol="{ span: 18, offset: 1 }"
              >
                <a-input-number style="width: 100%" placeholder="请输入" />
              </a-form-item>
            </a-col>
          </a-row>
          <a-row v-if="advanced">
            <a-col :md="8" :sm="24">
              <a-form-item
                label="更新日期"
                :labelCol="{ span: 5 }"
                :wrapperCol="{ span: 18, offset: 1 }"
              >
                <a-date-picker style="width: 100%" placeholder="请输入更新日期" />
              </a-form-item>
            </a-col>
            <a-col :md="8" :sm="24">
              <a-form-item
                label="使用状态"
                :labelCol="{ span: 5 }"
                :wrapperCol="{ span: 18, offset: 1 }"
              >
                <a-select placeholder="请选择">
                  <a-select-option value="1">关闭</a-select-option>
                  <a-select-option value="2">运行中</a-select-option>
                </a-select>
              </a-form-item>
            </a-col>
            <a-col :md="8" :sm="24">
              <a-form-item
                label="描述"
                :labelCol="{ span: 5 }"
                :wrapperCol="{ span: 18, offset: 1 }"
              >
                <a-input placeholder="请输入" />
              </a-form-item>
            </a-col>
          </a-row>
        </div>
        <span style="float: right; margin-top: 3px">
          <a-button type="primary">查询</a-button>
          <a-button style="margin-left: 8px">重置</a-button>
          <a @click="toggleAdvanced" style="margin-left: 8px">
            {{ advanced ? "收起" : "展开" }}
            <a-icon :type="advanced ? 'up' : 'down'" />
          </a>
        </span>
      </a-form>
    </div> -->
    <div>
      <!-- <a-space class="operator">
        <a-button @click="addNew" type="primary">新建</a-button>
        <a-button>批量操作</a-button>
        <a-dropdown>
          <a-menu @click="handleMenuClick" slot="overlay">
            <a-menu-item key="delete">删除</a-menu-item>
            <a-menu-item key="audit">审批</a-menu-item>
          </a-menu>
          <a-button> 更多操作 <a-icon type="down" /> </a-button>
        </a-dropdown>
      </a-space> -->
      <standard-table :columns="columns" :dataSource="dataSource" @clear="onClear" @change="onChange"
        :pagination="{ ...pagination, onChange: onPageChange }" @selectedRowChange="onSelectChange">
        <template slot="image-column" slot-scope="image">
          <img :src="image.text" style="max-width: 200px;" />
        </template>
        <template slot="status-column" slot-scope="status">
          <span v-if="status.text == null" style="
                    background-color: green;
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    display: inline-block;
                  ">
            active
          </span>
          <span v-if="status.text == 1" style="
                    background-color: red;
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    display: inline-block;
                  ">
            inactive
          </span>
        </template>

        <div slot="description" slot-scope="{ text }">
          {{ text }}
        </div>
        <div slot="action" slot-scope="{ text, record }" style="display: flex; flex-direction: column;">
          <a style="margin-right: 8px">
            <a-icon type="edit" />
            <router-link :to="`/banner/new?id=${record.id}`">Edit
            </router-link>
          </a>
          <a @click="deleteRecord(record.id)">
            <a-icon type="delete" />
            Delete
          </a>
          <a @click="changeStatus(record.id)">
            <a-icon type="info-circle" />
            Status
          </a>
        </div>
        <template slot="statusTitle">
          <a-icon @click.native="onStatusTitleClick" type="info-circle" />
        </template>
      </standard-table>
    </div>
  </a-card>
</template>

<script>
import StandardTable from "@/components/table/StandardTable";
import { request, METHOD } from "@/utils/request";
const columns = [
  {
    title: "ID",
    dataIndex: "id",
  },
  // {
  //   title: "Name",
  //   dataIndex: "callNo",
  //   sorter: true,
  //   needTotal: true,
  //   customRender: (text) => text + " 次",
  // },
  {
    title: "Image",
    dataIndex: "image",
    key: "image",
    scopedSlots: { customRender: "image-column" },
  },
  {
    title: "Status",
    dataIndex: "status",
    key: "status",
  },
  {
    title: "Action",
    scopedSlots: { customRender: "action" },
  },
];

export default {
  name: "QueryList",
  components: { StandardTable },
  data() {
    return {
      advanced: true,
      columns: columns,
      dataSource: [],
      selectedRows: [],
      pagination: {
        current: 1,
        pageSize: 10,
        total: 0,
      },
    };
  },
  // authorize: {
  //   deleteRecord: "delete",
  // },
  mounted() {
    this.getData();
  },
  methods: {
    onPageChange(page, pageSize) {
      this.pagination.current = page;
      this.pagination.pageSize = pageSize;
      this.getData();
    },
    getData() {
      request(process.env.VUE_APP_API_BASE_URL + "/banner", "get", {
        page: this.pagination.current,
        pageSize: this.pagination.pageSize,
      }).then((res) => {
        const { data, page, pageSize, total } = res?.data?.items ?? {};

        this.dataSource = data.map(_data => {
          return {
            ..._data,
            status: _data.status !== 1 ? "Inactive" : "Active",
            image: _data.image ? process.env.VUE_APP_API_BASE_URL.replace("/api", "") + _data.image : null,
          }
        });
        this.pagination.current = page;
        this.pagination.pageSize = pageSize;
        this.pagination.total = total;
      });
    },
    changeStatus(id) {
      request(process.env.VUE_APP_API_BASE_URL + "/banner/status/" + id, METHOD.PUT).then(() => {
        this.getData();
        this.$message.success("Change status success");
      })
    },
    deleteRecord(id) {
      const confirm = window.confirm("Are you sure to delete this record?");
      if (!confirm) return;
      request(process.env.VUE_APP_API_BASE_URL + "/banner/" + id, METHOD.DELETE).then(() => {
        this.getData();
        this.$message.success("Delete success");
      })
    },
    toggleAdvanced() {
      this.advanced = !this.advanced;
    },
    remove() {
      this.dataSource = this.dataSource.filter(
        (item) => this.selectedRows.findIndex((row) => row.key === item.key) === -1
      );
      this.selectedRows = [];
    },
    onClear() {
      this.$message.info("您清空了勾选的所有行");
    },
    onStatusTitleClick() {
      this.$message.info("你点击了状态栏表头");
    },
    onChange() {
      this.$message.info("表格状态改变了");
    },
    onSelectChange() {
      this.$message.info("选中行改变了");
    },
    addNew() {
      this.dataSource.unshift({
        key: this.dataSource.length,
        no: "NO " + this.dataSource.length,
        description: "这是一段描述",
        callNo: Math.floor(Math.random() * 1000),
        status: Math.floor(Math.random() * 10) % 4,
        updatedAt: "2018-07-26",
      });
    },
    handleMenuClick(e) {
      if (e.key === "delete") {
        this.remove();
      }
    },
  },
};
</script>

<style lang="less" scoped>
.search {
  margin-bottom: 54px;
}

.fold {
  width: calc(100% - 216px);
  display: inline-block;
}

.operator {
  margin-bottom: 18px;
}

@media screen and (max-width: 900px) {
  .fold {
    width: 100%;
  }
}
</style>
