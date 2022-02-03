<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Github List</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.0/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">

    <style>
        body {
            margin: 2rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid" style="margin-bottom: 20px;">
        <button type="button" class="btn btn-primary" id="syncup">Sync up</button>
    </div>

    <!-- Content -->
    <div class="container-fluid">
        <div class="row">
            <table id="example" class="display" width="100%"></table>
        </div>
    </div>

    <!-- Modal Loading -->
    <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loader"></div>
                    <div clas="loader-txt">
                        <p>Synchonizing Github Repositories</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Details -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row ml-10">
                        <div class="col" id="exampleModalLabel"></div>
                        <div class="col text-rigth"><span id="repo-stars"></div>
                        <div class="row ml-10">
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col"><label for="repo-name" class="col-form-label" id="repo-name"></div>
                                <div class="col"><label for="repo-url" class="col-form-label" id="repo-url"></div>
                                <div class="col"><label for="repo-created" class="col-form-label" id="repo-created"></div>
                                <div class="col"><label for="repo-pushed" class="col-form-label" id="repo-pushed"></div>
                                <div class="col"><label for="repo-description" class="col-form-label" id="repo-description"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {

            var table = false;
            $("#syncup").on('click', function() {
                synchonizeGithubRepositories();
            });

            function synchonizeGithubRepositories() {
                $("#loadMe").modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                });

                $.ajax({
                    url: "/repository/synchonize",
                    success: function(result) {
                        $("#loadMe").modal("hide");
                        loadGithubRepositories();
                    }
                });
            }

            function getStars(numStars) {
                return "⭐" + numStars;
            }

            function loadGithubRepositories() {
                if (table) {
                    $('#example').DataTable().destroy();
                }
                table = $('#example').DataTable({
                    "ajax": "/repository/loadData",
                    columns: [{
                            title: "Id",
                        },
                        {
                            title: "Name"
                        },
                        {
                            title: "Url"
                        },
                        {
                            title: "Created"
                        },
                        {
                            title: "Last Push"
                        },
                        {
                            title: "Description"
                        },
                        {
                            title: "Stars"
                        },
                    ],
                    columnDefs: [{
                            "render": function(data, type, row) {
                                return data.split(' ')[0]
                            },
                            "targets": [3, 4]
                        },
                        {
                            "render": function(data, type, row) {
                                return getStars(data)
                            },
                            "targets": 6
                        }
                    ]
                });

                $('#example tbody').on('click', 'tr', function() {
                    console.log(this, table);
                    var modal = $('#exampleModal');
                    console.log(table.row(this).data());
                    modal.find('#exampleModalLabel').text("Github Repository: " + table.row(this).data()[1] + " " + getStars(table.row(this).data()[6]))
                    modal.find('#repo-name').html("Name: " + table.row(this).data()[1])
                    modal.find('#repo-url').html("URL: " + table.row(this).data()[2])
                    modal.find('#repo-created').html("Created: " + table.row(this).data()[3])
                    modal.find('#repo-pushed').html("Last Push: " + table.row(this).data()[4])
                    modal.find('#repo-description').html("Description: " + table.row(this).data()[5])
                    modal.modal('show');
                });
            }

            loadGithubRepositories();
        });
    </script>
</body>

</html>