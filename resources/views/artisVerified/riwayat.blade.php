@extends('artisVerified.components.artisVerifiedTemplate')

@section('content')
    <div class="main-panel">
        <link rel="stylesheet" href="/user/assets/css/riwayat.css">
        <style>
            /* CSS untuk styling pagination */
            .pagination {
                margin-top: 20px;
            }

            .page-item:first-child .page-link {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                border-radius: 10px;
            }

            .page-item:last-child .page-link {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                border-radius: 10px;
            }

            .pagination li {
                display: inline;
                margin-right: 5px;
            }

            .pagination li a {
                text-decoration: none;
            }

            .page-link.active {
                background-color: #957DAD;
                border: 1px solid #957DAD;
            }

            .pagination li.active a {
                color: #fff;
            }

            .pagination li:hover {
                background-color: #ddd;
            }
        </style>
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="table-container">
                        <table class="table table-sortable">
                            <thead>
                                <tr class="table-row table-header">
                                    <th class="table-cell">Artis <i class="fas fa-sort" data-order="asc"></th>
                                    <th class="table-cell">Kategori <i class="fas fa-sort" data-order="asc"></th>
                                    <th class="table-cell">Tanggal <i class="fas fa-sort" data-order="asc"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uniqueRows->reverse() as $item)
                                    @if ($item->user_id === auth()->user()->id)
                                        <tr class="table-row baris">
                                            <td class="table-cell">
                                                <h6>{{ $item->song->judul }}</h6>
                                                <p class="text-muted m-0">{{ $item->song->artist->user->name }}</p>
                                            </td>
                                            <td class="table-cell">{{ $item->song->genre->name }}</td>
                                            <td class="table-cell">
                                                {{ $item->created_at->diffForHumans() }} </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <div class="text-center">
                            <ul class="pagination justify-content-center">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    <script src="/user/assets/js/tablesort.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var itemsPerPage = 4;
            var currentPage = 1;

            function setURLParameter(page) {
                var newURL = window.location.href.split('?')[0] + '?page=' + page;
                window.history.replaceState({}, document.title, newURL);
            }

            function getURLParameter() {
                var urlParams = new URLSearchParams(window.location.search);
                return parseInt(urlParams.get('page')) || 1;
            }

            currentPage = getURLParameter();

            function showTableRows() {
                var start = (currentPage - 1) * itemsPerPage;
                var end = start + itemsPerPage;
                $(".baris").hide();
                $(".baris").slice(start, end).show();
            }

            function updatePagination() {
                $(".pagination").empty();
                var numPages = Math.ceil($(".baris").length / itemsPerPage);

                for (var i = 1; i <= numPages; i++) {
                    var activeClass = i === currentPage ? "active" : "";
                    var buttonText = i.toString();
                    var buttonClass = "page-link";
                    if (i === currentPage) {
                        buttonClass += " active";
                    }

                    var button = $("<a>")
                        .addClass("page-item " + activeClass)
                        .addClass(buttonClass)
                        .attr("href", "?page=" + i) // Set the page number as a query parameter
                        .text(buttonText);

                    $(".pagination").append($("<li>").append(button));
                }

                if (numPages <= 1) {
                    $(".pagination").hide();
                }
            }

            showTableRows();
            updatePagination();

            setURLParameter(currentPage);
        });
    </script>
@endsection
