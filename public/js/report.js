/**
 * Sales Report Dashboard - Modular JavaScript
 * Author: Laravel Food Delivery System
 * Version: 1.0.0
 */

class SalesReportDashboard {
    constructor(config = {}) {
        this.config = {
            routes: {
                sales: "/dashboard/reports/sales",
                revenue: "/dashboard/reports/revenue",
            },
            selectors: {
                dateFilterForm: "#dateFilterForm",
                startDate: "#startDate",
                endDate: "#endDate",
                dateRangeText: "#dateRangeText",
                loadingOverlay: "#loadingOverlay",
                exportModal: "#exportModal",
            },
            charts: {
                dailySales: null,
                status: null,
                revenue: null,
            },
            currentFilter: {
                start_date: "",
                end_date: "",
                restaurant_id: "all",
            },
            ...config,
        };

        this.init();
    }

    init() {
        this.dateFilter = new DateFilterManager(this.config);
        this.chartManager = new ChartManager(this.config);
        this.dataLoader = new DataLoader(this.config);
        this.uiManager = new UIManager(this.config);
        this.exportManager = new ExportManager(this.config);

        this.bindGlobalEvents();
        this.setupGlobalFunctions();
    }

    bindGlobalEvents() {
        // Initialize modules
        this.dateFilter.init();
        this.chartManager.init();
    }

    setupGlobalFunctions() {
        // Make functions globally available for backward compatibility
        window.filterByRestaurant = (id) =>
            this.dateFilter.filterByRestaurant(id);
        window.resetDateFilter = () => this.dateFilter.reset();
        window.exportReport = (format) => {
            console.log("exportReport called with format:", format);
            this.exportManager.showExportModal(format);
        };

        // Make dateFilter available globally for quick filter buttons
        window.dateFilter = this.dateFilter;
    }
}

class DateFilterManager {
    constructor(config) {
        this.config = config;
    }

    init() {
        this.bindEvents();
        this.updateDateRangeText();
    }

    bindEvents() {
        $(this.config.selectors.dateFilterForm).on("submit", (e) => {
            e.preventDefault();
            this.applyCustomFilter();
        });
    }

    setQuickFilter(period) {
        const dates = this.getQuickFilterDates(period);
        $(this.config.selectors.startDate).val(dates.start);
        $(this.config.selectors.endDate).val(dates.end);
        this.applyFilter(dates.start, dates.end);
        this.updateDateRangeText(period);
    }

    getQuickFilterDates(period) {
        const today = new Date();
        const formatDate = (date) => date.toISOString().split("T")[0];

        const dateRanges = {
            today: () => ({
                start: formatDate(today),
                end: formatDate(today),
            }),
            yesterday: () => {
                const yesterday = new Date(
                    today.getTime() - 24 * 60 * 60 * 1000
                );
                return {
                    start: formatDate(yesterday),
                    end: formatDate(yesterday),
                };
            },
            this_week: () => {
                const weekStart = new Date(
                    today.setDate(today.getDate() - today.getDay())
                );
                return {
                    start: formatDate(weekStart),
                    end: formatDate(new Date()),
                };
            },
            last_week: () => {
                const lastWeekEnd = new Date(
                    today.setDate(today.getDate() - today.getDay() - 1)
                );
                const lastWeekStart = new Date(
                    lastWeekEnd.getTime() - 6 * 24 * 60 * 60 * 1000
                );
                return {
                    start: formatDate(lastWeekStart),
                    end: formatDate(lastWeekEnd),
                };
            },
            this_month: () => {
                const monthStart = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    1
                );
                return {
                    start: formatDate(monthStart),
                    end: formatDate(new Date()),
                };
            },
            last_month: () => {
                const lastMonthStart = new Date(
                    today.getFullYear(),
                    today.getMonth() - 1,
                    1
                );
                const lastMonthEnd = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    0
                );
                return {
                    start: formatDate(lastMonthStart),
                    end: formatDate(lastMonthEnd),
                };
            },
        };

        return dateRanges[period]
            ? dateRanges[period]()
            : { start: "", end: "" };
    }

    applyCustomFilter() {
        const startDate = $(this.config.selectors.startDate).val();
        const endDate = $(this.config.selectors.endDate).val();

        // Validate date range
        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            this.showError("Start date cannot be after end date");
            return;
        }

        this.applyFilter(startDate, endDate);
        this.updateDateRangeText();
    }

    applyFilter(startDate, endDate) {
        this.config.currentFilter.start_date = startDate;
        this.config.currentFilter.end_date = endDate;

        // Trigger data reload
        const dataLoader = new DataLoader(this.config);
        dataLoader.loadSalesData();
    }

    reset() {
        $(this.config.selectors.startDate).val("");
        $(this.config.selectors.endDate).val("");
        this.config.currentFilter.start_date = "";
        this.config.currentFilter.end_date = "";
        this.updateDateRangeText();

        const dataLoader = new DataLoader(this.config);
        dataLoader.loadSalesData();
    }

    updateDateRangeText(period = null) {
        const { start_date: startDate, end_date: endDate } =
            this.config.currentFilter;
        let text = "Date Range";

        if (period) {
            text = period
                .replace("_", " ")
                .replace(/\b\w/g, (l) => l.toUpperCase());
        } else if (startDate && endDate) {
            if (startDate === endDate) {
                text = new Date(startDate).toLocaleDateString();
            } else {
                text = `${new Date(
                    startDate
                ).toLocaleDateString()} - ${new Date(
                    endDate
                ).toLocaleDateString()}`;
            }
        } else if (startDate) {
            text = `From ${new Date(startDate).toLocaleDateString()}`;
        } else if (endDate) {
            text = `Until ${new Date(endDate).toLocaleDateString()}`;
        }

        $(this.config.selectors.dateRangeText).text(text);
    }

    filterByRestaurant(restaurantId) {
        this.config.currentFilter.restaurant_id = restaurantId;
        const dataLoader = new DataLoader(this.config);
        dataLoader.loadSalesData();
    }

    showError(message) {
        // Use Bootstrap toast or alert
        const alert = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $(".container-fluid").prepend(alert);

        // Auto dismiss after 5 seconds
        setTimeout(() => {
            $(".alert").alert("close");
        }, 5000);
    }
}

class ChartManager {
    constructor(config) {
        this.config = config;
        this.chartOptions = new ChartOptions();
    }

    init() {
        this.initializeDailySalesChart();
        this.initializeStatusChart();
        this.initializeRevenueChart();
    }

    initializeDailySalesChart() {
        const element = document.querySelector("#dailySalesChart");
        if (!element) return;

        const options = this.chartOptions.getDailySalesOptions();
        this.config.charts.dailySales = new ApexCharts(element, options);
        this.config.charts.dailySales.render();
    }

    initializeStatusChart() {
        const element = document.querySelector("#statusChart");
        if (!element) return;

        const options = this.chartOptions.getStatusChartOptions();
        this.config.charts.status = new ApexCharts(element, options);
        this.config.charts.status.render();
    }

    initializeRevenueChart() {
        const element = document.querySelector("#revenueChart");
        if (!element) return;

        const options = this.chartOptions.getRevenueChartOptions();
        this.config.charts.revenue = new ApexCharts(element, options);

        // Render chart and load data after a short delay to ensure DOM is ready
        this.config.charts.revenue.render().then(() => {
            setTimeout(() => {
                const dataLoader = new DataLoader(this.config);
                dataLoader.loadRevenueData();
            }, 100);
        });
    }

    updateDailySalesChart(data) {
        if (!data?.dailySales || !this.config.charts.dailySales) return;

        const labels = Object.keys(data.dailySales);
        const revenueData = Object.values(data.dailySales).map(
            (day) => day.total_revenue
        );
        const ordersData = Object.values(data.dailySales).map(
            (day) => day.total_orders
        );

        this.config.charts.dailySales.updateOptions({
            xaxis: { categories: labels },
        });
        this.config.charts.dailySales.updateSeries([
            { name: "Revenue (Rs.)", data: revenueData },
            { name: "Orders Count", data: ordersData },
        ]);
    }

    updateStatusChart(data) {
        if (!data?.statusDistribution || !this.config.charts.status) return;

        const chartData = [
            data.statusDistribution.completed?.count || 0,
            data.statusDistribution.confirmed?.count || 0,
            data.statusDistribution.preparing?.count || 0,
            data.statusDistribution.cancelled?.count || 0,
        ];

        this.config.charts.status.updateSeries(chartData);
    }

    updateRevenueChart(data) {
        if (!data || !this.config.charts.revenue) return;

        const labels = data.map((item) => {
            const [year, month] = item.month.split("-");
            return new Date(year, month - 1).toLocaleDateString("en-US", {
                month: "short",
                year: "numeric",
            });
        });
        const revenues = data.map((item) => parseFloat(item.revenue));

        this.config.charts.revenue.updateOptions({
            xaxis: { categories: labels },
        });
        this.config.charts.revenue.updateSeries([
            { name: "Revenue (Rs.)", data: revenues },
        ]);
    }
}

class ChartOptions {
    getDailySalesOptions() {
        return {
            series: [
                { name: "Revenue (Rs.)", type: "area", data: [] },
                { name: "Orders Count", type: "line", data: [] },
            ],
            chart: {
                height: 350,
                type: "line",
                toolbar: { show: true },
                animations: { enabled: true, easing: "easeinout", speed: 800 },
            },
            colors: ["#28a745", "#007bff"],
            stroke: { width: [0, 3], curve: "smooth" },
            fill: {
                type: ["gradient", "solid"],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100],
                },
            },
            markers: { size: 0 },
            xaxis: { type: "datetime", labels: { format: "dd MMM" } },
            yaxis: [
                {
                    title: { text: "Revenue (Rs.)" },
                    labels: {
                        formatter: (val) => "Rs. " + val.toLocaleString(),
                    },
                },
                { opposite: true, title: { text: "Orders Count" } },
            ],
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: (y, { seriesIndex }) =>
                        seriesIndex === 0
                            ? "Rs. " + y.toLocaleString()
                            : y + " orders",
                },
            },
            legend: { position: "top", horizontalAlign: "left" },
        };
    }

    getStatusChartOptions() {
        return {
            series: [],
            chart: {
                width: 380,
                type: "donut",
                animations: { enabled: true, easing: "easeinout", speed: 800 },
            },
            labels: ["Completed", "Confirmed", "Preparing", "Cancelled"],
            colors: ["#28a745", "#17a2b8", "#ffc107", "#dc3545"],
            plotOptions: {
                pie: {
                    donut: {
                        size: "60%",
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: "Total Orders",
                                fontSize: "16px",
                                fontWeight: 600,
                                color: "#373d3f",
                                formatter: (w) =>
                                    w.globals.seriesTotals.reduce(
                                        (a, b) => a + b,
                                        0
                                    ),
                            },
                            value: {
                                show: true,
                                fontSize: "22px",
                                fontWeight: "bold",
                                color: "#373d3f",
                            },
                        },
                    },
                },
            },
            dataLabels: { enabled: false },
            legend: {
                position: "bottom",
                fontSize: "14px",
                markers: { width: 12, height: 12, radius: 6 },
            },
            tooltip: {
                y: {
                    formatter: function (val, opts) {
                        const total = opts.globals.seriesTotals.reduce(
                            (a, b) => a + b,
                            0
                        );
                        const percentage =
                            total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                        return val + " orders (" + percentage + "%)";
                    },
                },
            },
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: { width: 280 },
                        legend: { position: "bottom" },
                    },
                },
            ],
        };
    }

    getRevenueChartOptions() {
        return {
            series: [{ name: "Revenue (Rs.)", data: [] }],
            chart: {
                height: 350,
                type: "bar",
                toolbar: { show: true },
                animations: { enabled: true, easing: "easeinout", speed: 800 },
            },
            colors: ["#36A2EB"],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: "60%",
                    dataLabels: { position: "top" },
                },
            },
            dataLabels: {
                enabled: true,
                formatter: (val) => "Rs. " + val.toLocaleString(),
                offsetY: -20,
                style: { fontSize: "12px", colors: ["#304758"] },
            },
            stroke: { show: true, width: 2, colors: ["transparent"] },
            xaxis: { categories: [], title: { text: "Month" } },
            yaxis: {
                title: { text: "Revenue (Rs.)" },
                labels: { formatter: (val) => "Rs. " + val.toLocaleString() },
            },
            fill: {
                opacity: 1,
                type: "gradient",
                gradient: {
                    shade: "light",
                    type: "vertical",
                    shadeIntensity: 0.25,
                    opacityFrom: 1,
                    opacityTo: 0.8,
                    stops: [0, 100],
                },
            },
            tooltip: {
                y: { formatter: (val) => "Rs. " + val.toLocaleString() },
            },
            grid: { borderColor: "#f1f1f1", strokeDashArray: 4 },
        };
    }
}

class DataLoader {
    constructor(config) {
        this.config = config;
    }

    loadSalesData() {
        const uiManager = new UIManager(this.config);
        const chartManager = new ChartManager(this.config);

        uiManager.showLoading();

        $.get(this.config.routes.sales, this.config.currentFilter)
            .done((data) => {
                uiManager.updateMetrics(data);
                chartManager.updateDailySalesChart(data);
                chartManager.updateStatusChart(data);
                uiManager.updateTopRestaurants(data.topRestaurants);
            })
            .fail((xhr, status, error) => {
                console.error("Failed to load sales data:", error);
                uiManager.showError(
                    "Failed to load sales data. Please try again."
                );
            })
            .always(() => uiManager.hideLoading());
    }

    loadRevenueData() {
        const chartManager = new ChartManager(this.config);

        $.get(this.config.routes.revenue, { chart_data: true })
            .done((data) => {
                chartManager.updateRevenueChart(data);
            })
            .fail((xhr, status, error) => {
                console.error("Failed to load revenue data:", error);
            });
    }
}

class UIManager {
    constructor(config) {
        this.config = config;
    }

    updateMetrics(data) {
        const metrics = {
            "#totalRevenue":
                "Rs. " + parseFloat(data.totalRevenue || 0).toLocaleString(),
            "#totalOrders": parseInt(data.totalOrders || 0).toLocaleString(),
            "#averageOrderValue":
                "Rs. " +
                parseFloat(data.averageOrderValue || 0).toLocaleString(),
            "#completionRate":
                parseFloat(data.completionRate || 0).toFixed(1) + "%",
        };

        Object.entries(metrics).forEach(([selector, value]) => {
            $(selector).text(value);
        });

        this.updateGrowthBadge(data.revenueGrowth || 0);
    }

    updateGrowthBadge(growth) {
        const growthBadge = $("#revenueGrowth");
        const growthValue = parseFloat(growth);
        const isPositive = growthValue >= 0;

        growthBadge.removeClass("bg-success bg-danger");
        growthBadge.addClass(isPositive ? "bg-success" : "bg-danger");
        growthBadge.html(`
            <i class="bi bi-arrow-${isPositive ? "up" : "down"}"></i>
            ${Math.abs(growthValue).toFixed(1)}%
        `);
    }

    updateTopRestaurants(restaurants) {
        const tbody = $("#topRestaurantsTable");
        tbody.empty();

        if (!restaurants || restaurants.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        No restaurant data available for the selected period.
                    </td>
                </tr>
            `);
            return;
        }

        const maxRevenue = restaurants[0]?.total_revenue || 1;

        restaurants.forEach((restaurant) => {
            const progressWidth = (restaurant.total_revenue / maxRevenue) * 100;
            const row = this.createRestaurantRow(restaurant, progressWidth);
            tbody.append(row);
        });
    }

    createRestaurantRow(restaurant, progressWidth) {
        return `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-2 me-3">
                            <i class="bi bi-shop text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">${restaurant.name}</h6>
                            <small class="text-muted">ID: ${
                                restaurant.id
                            }</small>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <span class="badge bg-primary">${
                        restaurant.total_orders
                    }</span>
                </td>
                <td class="text-end">
                    <strong class="text-success">Rs. ${parseFloat(
                        restaurant.total_revenue
                    ).toLocaleString()}</strong>
                </td>
                <td class="text-end">
                    Rs. ${parseFloat(
                        restaurant.avg_order_value
                    ).toLocaleString()}
                </td>
                <td class="text-center">
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: ${progressWidth}%"></div>
                    </div>
                </td>
            </tr>
        `;
    }

    showLoading() {
        $(this.config.selectors.loadingOverlay).removeClass("d-none");
    }

    hideLoading() {
        $(this.config.selectors.loadingOverlay).addClass("d-none");
    }

    showError(message) {
        // Simple alert for now, could be enhanced with toast notifications
        console.error(message);
        // You can implement a toast notification system here
    }
}

class ExportManager {
    constructor(config) {
        this.config = config;
    }

    showExportModal(format) {
        console.log("showExportModal called with format:", format);
        $("#exportStartDate").text(
            this.config.currentFilter.start_date || "All time"
        );
        $("#exportEndDate").text(
            this.config.currentFilter.end_date || "All time"
        );
        $("#exportRecordCount").text($("#totalOrders").text());

        console.log("Trying to show modal:", this.config.selectors.exportModal);

        // Try both Bootstrap and CoreUI modal methods
        const modal = $(this.config.selectors.exportModal);
        if (modal.length) {
            try {
                modal.modal("show");
            } catch (e) {
                console.log("Bootstrap modal failed, trying CoreUI:", e);
                // Alternative for CoreUI
                modal.addClass("show").css("display", "block");
                $("body").addClass("modal-open");
            }
        } else {
            console.error("Export modal not found!");
        }

        $("#confirmExport")
            .off("click")
            .on("click", () => {
                this.performExport(format);
            });
    }

    performExport(format) {
        console.log(`Exporting report as ${format.toUpperCase()}...`);

        // Get current filter parameters
        const startDate = this.config.currentFilter.start_date || "";
        const endDate = this.config.currentFilter.end_date || "";
        const restaurantId = this.config.currentFilter.restaurant_id || "";

        // Build query parameters
        const params = new URLSearchParams();
        if (startDate) params.append("start_date", startDate);
        if (endDate) params.append("end_date", endDate);
        if (restaurantId && restaurantId !== "all")
            params.append("restaurant_id", restaurantId);

        // Determine export URL based on format
        let exportUrl;
        switch (format.toLowerCase()) {
            case "pdf":
                exportUrl = `/dashboard/reports/export/pdf?${params.toString()}`;
                break;
            case "excel":
                exportUrl = `/dashboard/reports/export/excel?${params.toString()}`;
                break;
            case "csv":
                exportUrl = `/dashboard/reports/export/csv?${params.toString()}`;
                break;
            default:
                console.error("Unknown export format:", format);
                return;
        }

        // Hide modal
        const modal = $(this.config.selectors.exportModal);
        try {
            modal.modal("hide");
        } catch (e) {
            console.log("Bootstrap modal hide failed, trying CoreUI:", e);
            modal.removeClass("show").css("display", "none");
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        }

        // Show loading state
        $(".btn").prop("disabled", true);

        // Create a temporary link and trigger download
        const link = document.createElement("a");
        link.href = exportUrl;
        link.download = `sales-report-${
            new Date().toISOString().split("T")[0]
        }.${format.toLowerCase()}`;
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Re-enable buttons after a short delay
        setTimeout(() => {
            $(".btn").prop("disabled", false);
        }, 2000);

        // Show success message
        this.showExportSuccess(format);
    }

    showExportSuccess(format) {
        // You can replace this with a toast notification system
        const message = `${format.toUpperCase()} export completed successfully!`;

        // Simple success alert - replace with your notification system
        const alertDiv = $(`
            <div class="alert alert-success alert-dismissible fade show position-fixed"
                 style="top: 20px; right: 20px; z-index: 10000;">
                <strong>Success!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $("body").append(alertDiv);

        // Auto-remove after 3 seconds
        setTimeout(() => {
            alertDiv.alert("close");
        }, 3000);
    }
}

// Export for global use
window.SalesReportDashboard = SalesReportDashboard;
