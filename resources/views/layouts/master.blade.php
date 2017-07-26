<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="/vendor/light/assets/images/favicon_1.ico">

    <title>Ubold - Responsive Admin Dashboard Template</title>

    <!-- DataTables -->
    <link href="/vendor/light/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/plugins/custombox/css/custombox.css" rel="stylesheet">

    <link href="/vendor/light/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <link href="/vendor/light/assets/css/core.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/css/pages.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/light/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="/vendor/light/assets/js/modernizr.min.js"></script>

</head>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">
@include('layouts.header')
@include('layouts.leftbar')

@yield('content')


</div>
<!-- END wrapper -->

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="/vendor/light/assets/js/jquery.min.js"></script>
<script src="/vendor/light/assets/js/bootstrap.min.js"></script>
<script src="/vendor/light/assets/js/detect.js"></script>
<script src="/vendor/light/assets/js/fastclick.js"></script>
<script src="/vendor/light/assets/js/jquery.slimscroll.js"></script>
<script src="/vendor/light/assets/js/jquery.blockUI.js"></script>
<script src="/vendor/light/assets/js/waves.js"></script>
<script src="/vendor/light/assets/js/wow.min.js"></script>
<script src="/vendor/light/assets/js/jquery.nicescroll.js"></script>
<script src="/vendor/light/assets/js/jquery.scrollTo.min.js"></script>

<script src="/vendor/light/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script src="/vendor/light/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/jszip.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="/vendor/light/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/dataTables.scroller.min.js"></script>
<script src="/vendor/light/assets/plugins/datatables/dataTables.colVis.js"></script>
<script src="/vendor/light/assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

<script src="/vendor/light/assets/pages/datatables.init.js"></script>

<!-- Modal-Effect -->
<script src="/vendor/light/assets/plugins/custombox/js/custombox.min.js"></script>
<script src="/vendor/light/assets/plugins/custombox/js/legacy.min.js"></script>

<script src="/vendor/light/assets/js/jquery.core.js"></script>
<script src="/vendor/light/assets/js/jquery.app.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-colvid').DataTable({
            "dom": 'C<"clear">lfrtip',
            "colVis": {
                "buttonText": "Change columns"
            }
        });
        $('#datatable-scroller').DataTable({
            ajax: "/vendor/light/assets/plugins/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
        var table = $('#datatable-fixed-col').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            }
        });
    });
    TableManageButtons.init();

</script>

@yield('script')
</body>
</html>