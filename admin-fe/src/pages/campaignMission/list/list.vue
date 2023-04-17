
<template>
    <div>
        <a-card>
            <a-row>

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
                <standard-table :columns="columns" :dataSource="dataSource"
                    :pagination="{ ...pagination, onChange: onPageChange }">
                    <template slot="image-column" slot-scope="image">
                        <img :src="image.text" />
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
                        <a style="margin-right: 8px">
                            <a-icon type="edit" />
                            <router-link :to="`/campaignMission/new?id=${record.id}`">Edit
                            </router-link>
                        </a>
                        <a @click="deleteRecord(record.id)">
                            <a-icon type="delete" />
                            Delete
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
    </div>
</template>

<script>
import StandardTable from "@/components/table/StandardTable";
import { request } from "@/utils/request";
import { METHOD } from "../../../utils/request";
const columns = [
    {
        title: "ID",
        dataIndex: "id",
    },
    {
        title: "Name",
        dataIndex: "name",
        width: "20%",
    },
    {
        title: "Binding Fee",
        dataIndex: "binding_fee",
    },
    {
        title: "Daily Profit",
        dataIndex: "daily_profit",
    },
    {
        title: "Mission",
        dataIndex: "content",
    },
    {
        title: "Contract term",
        dataIndex: "contract_term",
        key: "contract_term",

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
            request(process.env.VUE_APP_API_BASE_URL + "/campain-mission", "get", {
                page: this.pagination.current,
                pageSize: this.pagination.pageSize,
            }).then((res) => {
                const { data, current_page: page, per_page: pageSize, total } = res?.data?.items ?? {};
                console.log(data);

                this.dataSource = data

                this.pagination.current = page;
                this.pagination.pageSize = pageSize;
                this.pagination.total = total;
            });
        },
        deleteRecord(id) {
            const confirmed = confirm("Are you sure to delete this record?");
            if (!confirmed) return;
            request(process.env.VUE_APP_API_BASE_URL + "/campain-mission/" + id, METHOD.DELETE).then(() => {
                this.getData();
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
