
<template>
    <div>
        <a-card>
            <a-row>
                <a @click="handleApproveAll()">
                    <a-icon type="check" />
                    Approve all
                </a>
            </a-row>
        </a-card>
        <a-card>
            <div>
                <a-space class="operator">
                    <!-- <a-button @click="addNew" type="primary">Add new</a-button> -->
                <!-- <a-dropdown>
                          <a-menu @click="handleMenuClick" slot="overlay">
                            <a-menu-item key="delete">删除</a-menu-item>
                            <a-menu-item key="audit">审批</a-menu-item>
                          </a-menu>
                          <a-button> 更多操作 <a-icon type="down" /> </a-button>
                            </a-dropdown> -->
                </a-space>
                <standard-table :columns="columns" :dataSource="dataSource">
                    <template slot="image-column" slot-scope="resuft">
                        <img :src="resuft.text" style="max-width: 200px;" />
                    </template>
                    <template slot="status-column" slot-scope="status">
                        <span v-if="status.text != 1" style="
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
                    <div slot="action" slot-scope="{  record }">
                        <a @click="checkRecord(record.id, 1)">
                            <a-icon type="check" />
                            Approve
                        </a>
                        <a @click="checkRecord(record.id, 2)">
                            <a-icon type="stop" />
                            Refuse
                        </a>
                    </div>
                    <template slot="statusTitle">
                        <a-icon @click.native="onStatusTitleClick" type="info-circle" />
                    </template>
                </standard-table>
            </div>
        </a-card>
    </div>
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
        dataIndex: "campain_name",
        width: "20%",
    },
    {
        title: "User",
        dataIndex: "user_name",
    },
    {
        title: "Amount",
        dataIndex: "price",
    },
    {
        title: "Explain",
        dataIndex: "resuft_explain",
        key: "resuft_explain",
        // scopedSlots: {customRender: "image-column"},

    },
    {
        title: "Image",
        dataIndex: "resuft",
        scopedSlots: { customRender: "image-column" },
    },
    {
        title: "Status",
        dataIndex: "status",
    },
    {
        title: "Reason Refuse",
        dataIndex: "reason",
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
            // pagination: {
            //     current: 1,
            //     pageSize: 10,
            //     total: 0,
            // },
        };
    },
    // authorize: {
    //   deleteRecord: "delete",
    // },
    mounted() {
        this.getData();
    },
    methods: {
        onPageChange() {
            // this.pagination.current = page;
            // this.pagination.pageSize = pageSize;
            this.getData();
        },
        getData() {
            request(process.env.VUE_APP_API_BASE_URL + "/result", "get", {
                // page: this.pagination.current,
                // pageSize: this.pagination.pageSize,
            }).then((res) => {
                const data = res?.data?.items ?? {};
                console.log(data);

                this.dataSource = data.map(_data => {
                    return {
                        ..._data,
                        resuft_explain: JSON.parse(_data.resuft_explain),
                        resuft: process.env.VUE_APP_API_BASE_URL.replace("/api", "") + JSON.parse(_data.resuft)[0],
                        status: _data.status == 0 ? "Pending" : _data.status == 1 ? "Approved" : "Refused",
                    }
                })

                // this.pagination.current = page;
                // this.pagination.pageSize = pageSize;
                // this.pagination.total = total;
            });
        },
        checkRecord(id, status) {
            let reason = "";
            if (status == 2) {
                reason = prompt("Please enter the reason for refusal", "");
                if (reason == null || reason == "") {
                    return;
                }
            }
            request(process.env.VUE_APP_API_BASE_URL + "/result/" + id, "put", {
                status,
                reason,
            }).then(() => {
                this.getData();
                this.$message.success(`Update successfully`);
            });
        },
        handleApproveAll() {
            request(process.env.VUE_APP_API_BASE_URL + "/result", "put", {
            }).then(() => {
                this.getData();
                this.$message.success(`Update successfully`);
            });
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
