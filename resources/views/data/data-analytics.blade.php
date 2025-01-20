<div id="data-analytics-result">
    <div id="chart"></div>
    <hr class="mb-4">
    <div class="data-table table-responsive">
     
        <table style="width: 100%;" class="table table-sm text-sm text-nowrap">
            <thead>
                <tr class="bg-light text-dark">
                    <th>Stations</th>
                    <th class="text-center">Avg Time (in Days)</th>
                    <th class="text-center">Avg Time (in Hours)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $index => $category)
                    <tr>
                        <td><span class="ms-3">{{ $category }}</span></td>
                        <td class="text-center">
                            @php
                                // Convert seconds to days
                                $days = isset($series[$index]) ? floor($series[$index] / (24 * 3600)) : 'N/A';
                            @endphp
                            <b>{{ $days }}</b> day(s)
                        </td>
                        <td class="text-center">
                            @php
                                // Convert seconds to hours
                                $hours = isset($series[$index]) ? number_format($series[$index] / 3600, 2) : 'N/A';
                            @endphp
                            <b>{{ $hours }}</b> hour(s)
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
    
    
    <script>
        // Log the series and categories data to ensure it's correctly passed
        console.log(@json($series)); // Log the series data
        console.log(@json($categories)); // Log the categories data

        var options = {
            chart: {
                height: 350,
                type: "area",
                stacked: false
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#FF1654"],
            series: [{
                name: "Average Time",
                data: @json($series) // Pass the series data from the controller
            }],
            stroke: {
                width: [2],
                curve: 'smooth'
            },
            xaxis: {
                categories: @json($categories), // Pass the section names as x-axis labels

                labels: {
                    formatter: function(value) {
                        if (value) {
                            const maxLength = 10; // Set the maximum number of characters before truncating
                            return value.length > maxLength ? value.substring(0, maxLength) + '...' : value;
                        }
                        return ''; // Return an empty string if value is undefined
                    },
                    style: {
                        whiteSpace: 'nowrap', // Prevent wrapping of the text
                        textOverflow: 'ellipsis', // Add ellipsis when text overflows
                        overflow: 'hidden', // Hide the overflowing part of the text
                        fontSize: '12px', // Adjust font size to fit the chart
                    },
                    rotate: -90 // Rotate labels if necessary to further reduce overlap
                }
            },
            colors: ["#dc3545"], // Base line color (red)
            fill: {
                type: 'gradient', // Enable gradient fill
                gradient: {
                    shade: 'light',
                    type: 'vertical', // Vertical gradient
                    shadeIntensity: 0.5,
                    gradientToColors: undefined, // Dynamic gradient stops
                    inverseColors: false,
                    opacityFrom: 0.5,
                    opacityTo: 0.5,
                    stops: [25, 75, 100], // Stops for high (red), mid (yellow), and low (green)
                    colorStops: [
                        {
                            offset: 25,
                            color: "#dc3545", // Red for higher values
                            opacity: 0.4
                        },
                        {
                            offset: 75,
                            color: "#ffc107", // Yellow for mid-range values
                            opacity: 0.4
                        },
                        {
                            offset: 100,
                            color: "#28a745", // Green for lower values
                            opacity: 0.4
                        }
                    ]
                }
            },
            yaxis: {
                title: {
                    text: "Average Time (Hours)"
                },
                labels: {
                    formatter: function(value) {
                        // Convert seconds to hours
                        const hours = (value / 3600).toFixed(1); // Convert to hours and format to 1 decimal place
                        return `${hours} h`; // Append "h" for hours
                    }
                }
            },
            tooltip: {
                enabled: true,
                shared: true, // Enable shared tooltip for multi-series
                intersect: false, // Tooltip will trigger on hover, not just the data point
                x: {
                    show: true, // Show the category (section name) in the tooltip
                    formatter: function(value) {
                        const categories = @json($categories); // Get the categories array
                        return `${categories[value - 1]}`;
                    }
                },
                y: {
                    formatter: function(val) {
                        // Convert seconds into days, hours, and minutes
                        const days = Math.floor(val / (24 * 3600));
                        const hours = Math.floor((val % (24 * 3600)) / 3600);
                        const minutes = Math.floor((val % 3600) / 60);

                        let result = "";
                        if (days > 0) result += `${days} ${days === 1 ? ' day' : ' days'}, `;
                        if (hours > 0 || days > 0) result += ` ${hours} ${hours === 1 ? ' hour' : ' hours'}, `;
                        result +=
                        ` ${minutes} ${minutes === 1 ? ' minute' : ' minutes'}`; // Use singular/plural for minutes

                        return result;
                    },

                    title: {
                        formatter: function(seriesName) {
                            return `${seriesName}: `; // Add a label before the value
                        }
                    }
                }
            },
            legend: {
                horizontalAlign: "center",
                offsetX: 40
            }
        };

        // Initialize and render the chart
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
</div>
