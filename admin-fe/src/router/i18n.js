const common_list_US = {
  list: { name: 'List' },
  new: { name: 'Add new' },
}
const common_list_CN = {
  list: { name: '列表' },
  new: { name: '添新' },
}
const common_list_VN = {
  list: { name: 'Danh sách' },
  new: { name: 'Thêm mới' },
}
module.exports = {


  messages: {
    VN: {
      home: { name: 'Trang chủ' },
      dashboard: {
        name: 'Dashboard',
      },
      exception: {
        name: 'Lỗi',
        404: { name: '404' },
        403: { name: '403' },
        500: { name: '500' }
      },
      systemConfig: {
        name: 'Cấu hình hệ thống',
        list: { name: 'Danh sách' },
        adminGroup: { name: 'Nhóm quản trị' },
        adminList: { name: 'Danh sách quản trị' }

      },
      components: {
        name: 'components',
        taskCard: { name: 'taskCard' },
        palette: { name: 'palette' }
      },
      bank: {
        name: 'Bank',
        ...common_list_VN
      },
      language: {
        name: 'Ngôn ngữ',
        ...common_list_VN
      },
      pictures: {
        name: 'Ảnh',

        popupList: { name: 'Danh sách popup' },
        ...common_list_VN
      },
      categories: {
        name: 'Danh mục',
        ...common_list_VN
      },
      articles: {
        name: 'Bài viết',
        ...common_list_VN
      },
      campaigns: {
        name: 'Chiến dịch',
        result: { name: 'Kết quả' },
        ...common_list_VN
      },
      campaignMission: {
        name: 'Nhiệm vụ chiến dịch',
        ...common_list_VN
      },
      partners: {
        name: 'Đối tác',
        exchange: { name: 'Đổi số dư' },
        ...common_list_VN
      },
      manageResult: {
        name: 'Quản lý kết quả',
        list: { name: 'Danh sách' },

      },
      payment: {
        name: 'Thanh toán',
        listIn: { name: 'Danh sách nạp tiền' },
        listOut: { name: 'Danh sách rút tiền' },
      }

    },
    CN: {
      home: {name: '首页'},
      bank: {
        name: '银行',
        ...common_list_CN
      },
      language: {
        name: '语言',
        ...common_list_CN
      },
      pictures: {
        name: '图像',
        popupList: { name: '弹出列表' },
        ...common_list_CN
      },
      categories: {
        name: '类别',
        ...common_list_CN
      },
      articles: {
        name: '帖子',
        ...common_list_CN
      },
      campaigns: {
        name: '活动',
        result: { name: '结果' },
        ...common_list_CN
      },
      campaignMission: {
        name: '活动任务',
        ...common_list_CN
      },
      partners: {
        name: '合作伙伴',
        exchange: { name: '更改余额' },
        ...common_list_CN
      },
      manageResult: {
        name: '管理结果',
        list: { name: '列表' },

      },
      payment: {
        name: '付款',
        listIn: { name: '充值清单' },
        listOut: { name: '撤回名单' },
      }
    },
    US: {
      home: {name: 'home'},
      systemConfig: {
        name: 'System Configuration',
        list: { name: 'System Configuration List' },
        adminGroup: { name: 'Administrator Group' },
        adminList: { name: 'Administrator List' }

      },
      bank: {
        name: 'Bank',
        ...common_list_US
      },
      language: {
        name: 'Language',
        ...common_list_US
      },
      pictures: {
        name: 'Pictures',
        popupList: { name: 'Popup list' },
        ...common_list_US
      },
      categories: {
        name: 'Categories',
        ...common_list_US
      },
      articles: {
        name: 'Articles',
        ...common_list_US
      },
      campaigns: {
        name: 'Campaigns',
        result: { name: 'Result' },
        ...common_list_US
      },
      campaignMission: {
        name: 'Campaign Mission',
        ...common_list_US
      },
      partners: {
        name: 'Partners',
        exchange: { name: 'Exchange' },
        ...common_list_US
      },
      manageResult: {
        name: 'Manage Result',
        list: { name: 'List' },

      },
      payment: {
        name: 'Payment',
        listIn: { name: 'List payment in' },
        listOut: { name: 'List payment out' },
      }

    },

    HK: {
      home: {name: '首頁'},
      dashboard: {
        name: 'Dashboard',
        workplace: {name: '工作台'},
        analysis: {name: '分析頁'}
      },
      form: {
        name: '表單頁',
        basic: {name: '基礎表單'},
        step: {name: '分步表單'},
        advance: {name: '分步表單'}
      },
      list: {
        name: '列表頁',
        query: {name: '查詢表格'},
        primary: {name: '標準列表'},
        card: {name: '卡片列表'},
        search: {
          name: '搜索列表',
          article: {name: '文章'},
          application: {name: '應用'},
          project: {name: '項目'}
        }
      },
      details: {
        name: '詳情頁',
        basic: {name: '基礎詳情頁'},
        advance: {name: '高級詳情頁'}
      },
      result: {
        name: '結果頁',
        success: {name: '成功'},
        error: {name: '失敗'}
      },
      exception: {
        name: '異常頁',
        404: {name: '404'},
        403: {name: '403'},
        500: {name: '500'}
      },
      components: {
        name: '小組件',
        taskCard: {name: '任務卡片'},
        palette: {name: '顏色複選框'}
      }
    }
  }
}
