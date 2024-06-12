import config from './index'

export default {
    successCode: config.successCode,
    pageSize: 15,
    pageSizes: [5, 10, 15, 20, 30, 40, 50, 100],
    paginationLayout: "total, prev, pager, next, jumper,slot",
    request: {
        page:1,
        limit:15,
        prop: "",
        order: ""
    },
}
