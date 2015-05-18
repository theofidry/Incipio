'use strict';

var datatables_options = require('./modules/datatables.js');
var dt_users = require('./modules/datatables-users.js');

$.extend($.fn.dataTable.defaults, datatables_options);

dt_users.init();
