import BlankView from '@/layouts/BlankView'
import PageView from '@/layouts/PageView'
import TabsView from '@/layouts/tabs/TabsView'

// 路由配置
const options = {
  routes: [
    {
      path: '/login',
      name: '登录页',
      component: () => import('@/pages/login')
    },
    {
      path: '*',
      name: '404',
      component: () => import('@/pages/exception/404'),
    },
    {
      path: '/403',
      name: '403',
      component: () => import('@/pages/exception/403'),
    },
    {
      path: '/',
      name: '首页',
      component: TabsView,
      redirect: '/login',
      children: [
        {
          path: 'bank',
          name: 'Bank',
          meta: {
            icon: 'bank',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/bank/list/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/bank/new/new'),
            },
            {
              path: 'edit',
              name: 'edit',
              meta: {
                invisible: true
              },
              component: () => import('@/pages/bank/edit/edit'),
            },

          ]
        },
        {
          path: 'language',
          name: 'Language',
          meta: {
            icon: 'global',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/language/list/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/language/new/new'),
            },
            {
              path: 'edit',
              name: 'edit',
              meta: {
                invisible: true
              },
              component: () => import('@/pages/language/edit/edit'),
            },

          ]
        },
        {
          path: 'pictures',
          name: 'Pictures',
          meta: {
            icon: 'picture',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/systemConfig/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/systemConfig/adminGroup'),
            },
            {
              path: 'popupList',
              name: 'popupList',
              component: () => import('@/pages/systemConfig/list'),
            },

          ]
        },
        {
          path: 'categories',
          name: 'Categories',
          meta: {
            icon: 'bars',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/categories/list/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/categories/new/new'),
            },
            {
              path: 'edit',
              name: 'edit',
              meta: {
                invisible: true
              },
              component: () => import('@/pages/categories/edit/edit'),
            },

          ]
        },
        {
          path: 'articles', //bài báo
          name: 'articles',
          meta: {
            icon: 'book',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/articles/list/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/articles/new/new'),
            },
            {
              path: 'edit',
              name: 'edit',
              meta: {
                invisible: true
              },
              component: () => import('@/pages/articles/edit/edit'),
            },

          ]
        },
        {
          path: 'campaigns',
          name: 'campaigns',
          meta: {
            icon: 'project',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/systemConfig/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/systemConfig/adminGroup'),
            },
            {
              path: 'result',
              name: 'Result',
              component: () => import('@/pages/systemConfig/list'),
            },

          ]
        },
        {
          path: 'campaignMission',
          name: 'campaignMission',
          meta: {
            icon: 'exclamation',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/systemConfig/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/systemConfig/adminGroup'),
            },

          ]
        },
        {
          path: 'partners',
          name: 'partners',
          meta: {
            icon: 'team',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/systemConfig/list'),
            },
            {
              path: 'new',
              name: 'New',
              component: () => import('@/pages/systemConfig/adminGroup'),
            },
            {
              path: 'exchange',//đổi số dư
              name: 'exchange',
              component: () => import('@/pages/systemConfig/adminGroup'),
            },

          ]
        },
        {
          path: 'manageResult',
          name: 'manageResult',
          meta: {
            icon: 'user',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: 'List',
              component: () => import('@/pages/systemConfig/list'),
            },
          ]
        },
        {
          path: 'payment',
          name: 'payment',
          meta: {
            icon: 'credit-card',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'listIn',
              name: 'listIn',
              component: () => import('@/pages/systemConfig/list'),
            },
            {
              path: 'listOut',
              name: 'listOut',
              component: () => import('@/pages/systemConfig/list'),
            },
          ]
        },

        {
          path: 'dashboard',
          name: 'platform-home',
          meta: {
            icon: 'dashboard'
          },
          component: BlankView,
          children: [
            // {
            //   path: 'workplace',
            //   name: '工作台',
            //   meta: {
            //     page: {
            //       closable: false
            //     }
            //   },
            //   component: () => import('@/pages/dashboard/workplace'),
            // },
            {
              path: 'analysis',
              name: '分析页',
              component: () => import('@/pages/dashboard/analysis'),
            }
          ]
        },
        {
          path: 'form',
          name: '表单页',
          meta: {
            icon: 'form',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'basic',
              name: '基础表单',
              component: () => import('@/pages/form/basic'),
            },
            {
              path: 'step',
              name: '分步表单',
              component: () => import('@/pages/form/step'),
            },
            {
              path: 'advance',
              name: '高级表单',
              component: () => import('@/pages/form/advance'),
            }
          ]
        },

        {
          path: 'systemConfig',
          name: '表单页',
          meta: {
            icon: 'form',
            page: {
              cacheAble: false
            }
          },
          component: PageView,
          children: [
            {
              path: 'list',
              name: '基础表单',
              component: () => import('@/pages/systemConfig/list'),
            },
            {
              path: 'adminGroup',
              name: '分步表单',
              component: () => import('@/pages/systemConfig/adminGroup'),
            },
            {
              path: 'adminList',
              name: '高级表单',
              component: () => import('@/pages/systemConfig/adminList'),
            }
          ]
        },
        {
          path: 'list',
          name: '列表页',
          meta: {
            icon: 'table'
          },
          component: PageView,
          children: [
            {
              path: 'query',
              name: '查询表格',
              meta: {
                authority: 'queryForm',
              },
              component: () => import('@/pages/list/QueryList'),
            },
            {
              path: 'query/detail/:id',
              name: '查询详情',
              meta: {
                highlight: '/list/query',
                invisible: true
              },
              component: () => import('@/pages/Demo')
            },
            {
              path: 'primary',
              name: '标准列表',
              component: () => import('@/pages/list/StandardList'),
            },
            {
              path: 'card',
              name: '卡片列表',
              component: () => import('@/pages/list/CardList'),
            },
            {
              path: 'search',
              name: '搜索列表',
              component: () => import('@/pages/list/search/SearchLayout'),
              children: [
                {
                  path: 'article',
                  name: '文章',
                  component: () => import('@/pages/list/search/ArticleList'),
                },
                {
                  path: 'application',
                  name: '应用',
                  component: () => import('@/pages/list/search/ApplicationList'),
                },
                {
                  path: 'project',
                  name: '项目',
                  component: () => import('@/pages/list/search/ProjectList'),
                }
              ]
            }
          ]
        },
        {
          path: 'details',
          name: '详情页',
          meta: {
            icon: 'profile'
          },
          component: BlankView,
          children: [
            {
              path: 'basic',
              name: '基础详情页',
              component: () => import('@/pages/detail/BasicDetail')
            },
            {
              path: 'advance',
              name: '高级详情页',
              component: () => import('@/pages/detail/AdvancedDetail')
            }
          ]
        },
        {
          path: 'result',
          name: '结果页',
          meta: {
            icon: 'check-circle-o',
          },
          component: PageView,
          children: [
            {
              path: 'success',
              name: '成功',
              component: () => import('@/pages/result/Success')
            },
            {
              path: 'error',
              name: '失败',
              component: () => import('@/pages/result/Error')
            }
          ]
        },
        {
          path: 'exception',
          name: '异常页',
          meta: {
            icon: 'warning',
          },
          component: BlankView,
          children: [
            {
              path: '404',
              name: 'Exp404',
              component: () => import('@/pages/exception/404')
            },
            {
              path: '403',
              name: 'Exp403',
              component: () => import('@/pages/exception/403')
            },
            {
              path: '500',
              name: 'Exp500',
              component: () => import('@/pages/exception/500')
            }
          ]
        },
        {
          path: 'components',
          name: '内置组件',
          meta: {
            icon: 'appstore-o'
          },
          component: PageView,
          children: [
            {
              path: 'taskCard',
              name: '任务卡片',
              component: () => import('@/pages/components/TaskCard')
            },
            {
              path: 'palette',
              name: '颜色复选框',
              component: () => import('@/pages/components/Palette')
            },
            {
              path: 'table',
              name: '高级表格',
              component: () => import('@/pages/components/table')
            }
          ]
        },
        {
          name: '验权表单',
          path: 'auth/form',
          meta: {
            icon: 'file-excel',
            authority: {
              permission: 'form'
            }
          },
          component: () => import('@/pages/form/basic')
        },
        {
          name: '带参菜单',
          path: 'router/query',
          meta: {
            icon: 'project',
            query: {
              name: '菜单默认参数'
            }
          },
          component: () => import('@/pages/Demo')
        },
        {
          name: '动态路由菜单',
          path: 'router/dynamic/:id',
          meta: {
            icon: 'project',
            params: {
              id: 123
            }
          },
          component: () => import('@/pages/Demo')
        },
        {
          name: 'Ant Design Vue',
          path: 'antdv',
          meta: {
            icon: 'ant-design',
            link: 'https://www.antdv.com/docs/vue/introduce-cn/'
          }
        },
        {
          name: '使用文档',
          path: 'document',
          meta: {
            icon: 'file-word',
            link: 'https://iczer.gitee.io/vue-antd-admin-docs/'
          }
        }
      ]
    },
  ]
}

export default options
