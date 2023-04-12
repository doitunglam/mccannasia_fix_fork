<template>
    <a-card>
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
            <standard-table
                    :columns="columns"
                    :dataSource="dataSource"

                    :pagination="{ ...pagination, onChange: onPageChange }"

            >
                <template slot="image-column" slot-scope="image">
                    <img :src="image.text" />
                </template>
                <template slot="status-column" slot-scope="status">
          <span
                  v-if="status.text != 1"
                  style="
              background-color: green;
              color: white;
              padding: 4px 8px;
              border-radius: 4px;
              display: inline-block;
            "
          >
            active
          </span>
                    <span
                            v-if="status.text == 1"
                            style="
              background-color: red;
              color: white;
              padding: 4px 8px;
              border-radius: 4px;
              display: inline-block;
            "
                    >
            inactive
          </span>
                </template>

                <div slot="description" slot-scope="{ text }">
                    {{ text }}
                </div>
                <div slot="action" slot-scope="{  record }">
                    <a style="margin-right: 8px">
                        <a-icon type="edit" />
                        <router-link :to="`/language/edit/edit/${record.id}`"
                        >edit</router-link
                        >
                    </a>
                    <a @click="deleteRecord(record.id)">
                        <a-icon type="delete" />
                        delete
                    </a>
                    <!-- <a @click="deleteRecord(record.key)" v-auth="`delete`">
                                <a-icon type="delete" />删除2
                              </a> -->
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
import { request } from "@/utils/request";

const columns = [
    {
        title: "ID",
        dataIndex: "id",
    },
    {
        title: "Name",
        dataIndex: "name",
    },
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
        scopedSlots: { customRender: "status-column" },
        sorter: (a, b) => a.status.localeCompare(b.status),
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
            request(process.env.VUE_APP_API_BASE_URL + "/list", "get", {
                page: this.pagination.current,
                pageSize: this.pagination.pageSize,
            }).then((res) => {
                const { list, page, pageSize, total } = res?.data?.data ?? {};
                console.log(list);

                this.dataSource = [
                    {
                        id: 1,
                        name: "Mobile app",
                        description: "",
                        image: "https://picsum.photos/200/300",
                        created_at: "2023-02-27 01:32:00",
                        updated_at: "2023-02-27 01:32:00",
                    },
                    {
                        id: 2,
                        name: "Dịch vụ tài chính",
                        description: "",
                        image: "https://picsum.photos/200/300",

                        created_at: "2023-02-27 01:34:45",
                        updated_at: "2023-02-27 01:34:45",
                    },
                    {
                        id: 3,
                        name: "Giáo dục",
                        description: "",
                        image: "https://picsum.photos/200/300",

                        created_at: "2023-02-27 01:34:45",
                        updated_at: "2023-02-27 01:34:45",
                    },
                    {
                        id: 4,
                        name: "Tiktok",
                        description: "",
                        image: "https://picsum.photos/200/300",

                        created_at: "2023-02-27 01:34:45",
                        updated_at: "2023-02-27 01:34:45",
                    },
                    {
                        id: 5,
                        name: "Shopee",
                        description: "",
                        image: "https://picsum.photos/200/300",

                        created_at: "2023-02-27 01:34:45",
                        updated_at: "2023-02-27 01:34:45",
                    },
                    {
                        id: 6,
                        name: "Dịch vụ trực tuyến",
                        description: "",
                        image: "https://picsum.photos/200/300",

                        created_at: "2023-03-03 14:13:08",
                        updated_at: "2023-03-03 14:13:08",
                    },
                    {
                        id: 7,
                        name: "Du lịch & Giải trí",
                        description: "",
                        image: "https://picsum.photos/200/300",

                        created_at: "2023-03-03 14:13:08",
                        updated_at: "2023-03-03 14:13:08",
                    },
                    {
                        id: 8,
                        name: "Làm đẹp",
                        description: "",
                        image: "https://picsum.photos/200/300",

                        created_at: "2023-03-03 14:13:08",
                        updated_at: "2023-03-03 14:13:08",
                    },
                ];

                this.pagination.current = page;
                this.pagination.pageSize = pageSize;
                this.pagination.total = total;
            });
        },
        deleteRecord(id) {
            this.dataSource = this.dataSource.filter((item) => item.id !== id);
            this.selectedRows = this.selectedRows.filter((item) => item.id !== id);
        },
        toggleAdvanced() {
            this.advanced = !this.advanced;
        },
        remove() {
            this.dataSource = this.dataSource.filter(
                (item) =>
                    this.selectedRows.findIndex((row) => row.key === item.key) === -1
            );
            this.selectedRows = [];
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
