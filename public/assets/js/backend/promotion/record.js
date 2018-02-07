define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'promotion/record/index',
                    add_url: 'promotion/record/add',
                    edit_url: 'promotion/record/edit',
                    del_url: 'promotion/record/del',
                    multi_url: 'promotion/record/multi',
                    table: 'promotion_record',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user.username', title: __('Username')},
                        {field: 'archives.title', title: __('advert name')},
                        {field: 'type', title: __('Type'), formatter: function (value) {
                            return value == 'add' ? __('添加收益') : __('减少收益');
                        }},
                        {field: 'status', title: __('Status'), formatter: function (value) {
                            return value == '1' ? __('Normal') : __('advert fail');
                        }},
                        {field: 'money', title: __('金额')},
                        {field: 'create_time', title: __('Create time'), formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update time'), formatter: Table.api.formatter.datetime},
                        {field: 'create_ip', title: __('Create_ip')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});