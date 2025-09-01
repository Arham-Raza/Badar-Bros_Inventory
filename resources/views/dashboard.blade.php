@extends('layouts.master')
@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <!-- [Invoices Awaiting Payment] start -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-4 d-flex align-items-start justify-content-between">
                                    <div class="gap-4 d-flex align-items-center">
                                        <div class="bg-gray-200 avatar-text avatar-lg">
                                            <i class="feather-shopping-cart"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark"><span
                                                    class="counter">{{ number_format($totalSales) }}</span></div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Sales</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">{{ number_format($totalMonthSales) }} / {{ number_format($averageMonthlySales) }}</a>
                                        <div class="w-10 text-end">
                                            <span class="fs-11 text-muted">({{ $salesPercentage }}%)</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 progress ht-3">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $salesPercentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [Invoices Awaiting Payment] end -->
                    <!-- [Converted Leads] start -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-4 d-flex align-items-start justify-content-between">
                                    <div class="gap-4 d-flex align-items-center">
                                        <div class="bg-gray-200 avatar-text avatar-lg">
                                            <i class="feather-shopping-bag"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold text-dark"><span
                                                    class="counter">{{ $totalPurchases }}</span></div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Purchases</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">{{ number_format($totalMonthPurchases) }} / {{ number_format($averageMonthlyPurchase) }}</a>
                                        <div class="w-10 text-end">
                                            <span class="fs-11 text-muted">({{ $purchasessPercentage }}%)</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 progress ht-3">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{ $purchasessPercentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [Converted Leads] end -->
                    <!-- [Projects In Progress] start -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-4 d-flex align-items-start justify-content-between">
                                    <div class="gap-4 d-flex align-items-center">
                                        <div class="bg-gray-200 avatar-text avatar-lg">
                                            <i class="feather-download"></i>
                                        </div>
                                        <div>
                                            <div class="fs-5 fw-bold text-dark"><span
                                                    class="counter">Rs.{{ number_format($totalReceipts) }}</span></div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Receipts</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">{{ number_format($totalMonthReceipts) }} / {{ number_format($averageMonthlyReceipts) }}</a>
                                        <div class="w-10 text-end">
                                            <span class="fs-11 text-muted">({{ $receiptsPercentage }}%)</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 progress ht-3">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $receiptsPercentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [Projects In Progress] end -->
                    <!-- [Conversion Rate] start -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-4 d-flex align-items-start justify-content-between">
                                    <div class="gap-4 d-flex align-items-center">
                                        <div class="bg-gray-200 avatar-text avatar-lg">
                                            <i class="feather-upload"></i>
                                        </div>
                                        <div>
                                            <div class="fs-5 fw-bold text-dark"><span class="counter">Rs.
                                                    {{ number_format($totalPayments) }}</span></div>
                                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Payments</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">{{ number_format($totalMonthPayments) }} / {{ number_format($averageMonthlyPayments) }}</a>
                                        <div class="w-10 text-end">
                                            <span class="fs-11 text-muted">({{ $paymentsPercentage }}%)</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 progress ht-3">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ $paymentsPercentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [Conversion Rate] end -->
                    <!-- [Payment Records] start -->
                    <div class="col-xxl-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header d-block">
                                <div class="mb-2 card-header-action justify-content-between">
                                    <h5 class="mb-2 card-title ">Payment Record</h5>
                                    <div class="card-header-btn">
                                        <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success"
                                                data-bs-toggle="expand"> </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-3">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="mb-1 fs-12 text-muted">Sales Receipt</div>
                                            <h6 class="fw-bold text-dark">Rs
                                                {{ number_format(array_sum($salesData['paid'])) }}</h6>
                                            <div class="mt-2 progress ht-3">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 81%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="mb-1 fs-12 text-muted">Sales Receivable</div>
                                            <h6 class="fw-bold text-dark">Rs
                                                {{ number_format(array_sum($salesData['due'])) }}</h6>
                                            <div class="mt-2 progress ht-3">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 82%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="mb-1 fs-12 text-muted">Purchase Paid</div>
                                            <h6 class="fw-bold text-dark">Rs
                                                {{ number_format(array_sum($purchaseData['paid'])) }}</h6>
                                            <div class="mt-2 progress ht-3">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 68%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="p-3 border border-dashed rounded">
                                            <div class="mb-1 fs-12 text-muted">Purchase Due</div>
                                            <h6 class="fw-bold text-dark">Rs
                                                {{ number_format(array_sum($purchaseData['due'])) }}</h6>
                                            <div class="mt-2 progress ht-3">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 75%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-0 card-body custom-card-action">
                                <div id="payment-records-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- [Payment Records] end -->

                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ url('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const salesData = @json($salesData);
            const purchaseData = @json($purchaseData);
            new ApexCharts(document.querySelector("#payment-records-chart"), {
                chart: {
                    type: "bar",
                    stacked: true,
                    height: 380
                },
                stroke: {
                    width: [1, 2, 3],
                    curve: "smooth",
                    lineCap: "round"
                },
                plotOptions: {
                    bar: {
                        endingShape: "rounded",
                        columnWidth: "30%"
                    },
                },
                colors: ["#c3b17f", "#a2acc7", "#000", "#E1E3EA"],
                series: [{
                        name: "Sales Paid",
                        data: salesData.paid
                    },
                    {
                        name: "Sales Due",
                        data: salesData.due
                    },
                    {
                        name: "Purchases Paid",
                        data: purchaseData.paid
                    },
                    {
                        name: "Purchases Due",
                        data: purchaseData.due
                    }
                ],
                fill: {
                    opacity: [0.85, 0.25, 1, 1],
                    gradient: {
                        inverseColors: !1,
                        shade: "light",
                        type: "vertical",
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 100, 100, 100],
                    },
                },
                markers: {
                    size: 0
                },
                xaxis: {
                    categories: salesData.labels,
                    axisBorder: {
                        show: !1
                    },
                    axisTicks: {
                        show: !1
                    },
                    labels: {
                        style: {
                            fontSize: "10px",
                            colors: "#A0ACBB"
                        }
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(e) {
                            return +e + "K";
                        },
                        offsetX: -5,
                        offsetY: 0,
                        style: {
                            color: "#A0ACBB"
                        },
                    },
                },
                dataLabels: {
                    enabled: !1
                },
                tooltip: {
                    y: {
                        formatter: val => "Rs " + val.toLocaleString()
                    },
                    style: {
                        fontSize: "12px",
                        fontFamily: "Inter"
                    },
                },
                legend: {
                    show: !1,
                    labels: {
                        fontSize: "12px",
                        colors: "#A0ACBB"
                    },
                    fontSize: "12px",
                    fontFamily: "Inter",
                }
            }).render();
        });
    </script>
@endsection
