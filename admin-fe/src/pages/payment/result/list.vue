
<template>
    <div>
        <a-card>
            <a-row>

            </a-row>
        </a-card>
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
                        <img :src="image.text"/>
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

                    <div slot = "date-public-column" slot-scope="date_public">

                        <div>
                            <p>{{formatTime(date_public.text)}}</p>
                        </div>
                    </div>
                    <div slot = "date-end-column" slot-scope="date_end">

                        <div>
                            <p>{{formatTime(date_end.text)}}</p>
                        </div>
                    </div>
                    <div slot="action" slot-scope="{  record }">
                        <a style="margin-right: 8px">
                            <a-icon type="edit"/>
                            <router-link :to="`/language/edit/edit/${record.id}`"
                            >edit
                            </router-link
                            >
                        </a>
                        <a @click="deleteRecord(record.id)">
                            <a-icon type="delete"/>
                            delete
                        </a>
                        <!-- <a @click="deleteRecord(record.key)" v-auth="`delete`">
                                    <a-icon type="delete" />删除2
                                  </a> -->
                    </div>
                    <template slot="statusTitle">
                        <a-icon @click.native="onStatusTitleClick" type="info-circle"/>
                    </template>
                </standard-table>
            </div>
        </a-card>
    </div>

</template>

<script>


import StandardTable from "@/components/table/StandardTable";
import {request} from "@/utils/request";
import moment from "moment";

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
        scopedSlots: {customRender: "image-column"},
    },
    {
        title: "Public Date",
        dataIndex: "date_public",
        key: "date_public",
        scopedSlots: {customRender: "date-public-column"},

        // render: (record) => {
        //     console.log(record);
        //     return (
        //         <div>
        //             <p>{moment(record.date_public).format("DD-MM-YYYY")}</p>
        //         </div>
        //     );
        // },
    },
    {
        title: "End Date",
        dataIndex: "date_end",
        key: "date_end",
        scopedSlots: {customRender: "date-end-column"},

        // render: (record) => {
        //     return (
        //         <div>
        //             <p>{moment(record.date_public).format("DD-MM-YYYY")}</p>
        //         </div>
        //     );
        // },
    },
    {
        title: "Status",
        dataIndex: "status",
        key: "status",
        scopedSlots: {customRender: "status-column"},
        sorter: (a, b) => a.status.localeCompare(b.status),
    },
    {
        title: "Action",
        scopedSlots: {customRender: "action"},
    },
];

export default {
    name: "QueryList",
    components: {StandardTable},
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
        formatTime(time){
            const result = moment(time).format("DD-MM-YYYY");
            if (result === "Invalid date") {
                return "no date";
            }
            return result
        },
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
                const { page, pageSize, total} = res?.data?.data ?? {};


                this.dataSource = [
                    {
                        "id" : 2,
                        "campain" : 1,
                        "user" : 1,
                        "resuft" : "{\"1\":[\"/upload/images/files/1.PNG\",\"/upload/images/files/download%20(1).png\",\"/upload/images/files/Flag_of_Vietnam_svg.png\"],\"2\":[\"/upload/images/files/Flag_of_Vietnam_svg.png\"]}",
                        "status" : 0,
                        "campain_name" : "{\"en\":\"What is Lorem Ipsum?\",\"vi\":\"What is Lorem Ipsum? viet nam\"}",
                        "user_name" : "Supper Admin",
                        "image" : "{\"en\":\"/upload/images/files/download%20(1).png\",\"vi\":\"/upload/images/files/Flag_of_Vietnam_svg.png\"}",
                        "list_task" : "{\"en\":[null,\"Chia s\u1ebb  3 forum facebook english\",\"chia s\u1ebb voz end\"],\"vi\":[null,\"Chia s\u1ebb v\u00e0o voz 1\",\"Chia s\u1ebb v\u00e0o voz2\"]}",
                        "price" : 5000,
                        "created_at" : "2023-02-15 23:24:07",
                        "updated_at" : "2023-02-15 23:34:13",
                        "use_" : null,
                        "date" : null,
                        "resuft_explain" : null
                    },
                    {
                        "id" : 3,
                        "campain" : 4,
                        "user" : 3,
                        "resuft" : "[[\"/upload/images/files/1.PNG\",\"/upload/images/files/download%20(1).png\"]]",
                        "status" : 1,
                        "campain_name" : "Bank Số Đẹp",
                        "user_name" : "Đại lý 1",
                        "image" : null,
                        "list_task" : "[\"\u0110\u0103ng ba\u0300i gi\u01a1i thi\u00ea\u0323u v\u00ea\u0300 app tr\u00ean trang facebook ca\u0301 nh\u00e2n, va\u0300 zalo ca\u0301 nh\u00e2n 1 nga\u0300y 2 l\u00e2\u0300n.\nM\u00f4\u0303i tu\u00e2\u0300n m\u01a1i t\u00f4\u0301i thi\u00ea\u0309u 1 tha\u0300nh vi\u00ean \u0111\u0103ng ky\u0301 tha\u0300nh c\u00f4ng ta\u0300i khoa\u0309n tr\u00ean trang web McCannasia.com\"]",
                        "price" : 150000,
                        "created_at" : "2023-02-27 02:59:09",
                        "updated_at" : "2023-02-27 03:46:02",
                        "use_" : "",
                        "date" : "27-02-2023",
                        "resuft_explain" : null
                    }
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
