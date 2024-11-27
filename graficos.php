<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos en Tiempo Real</title>
    <style>
        .chart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        h2 {
            text-align: center;
        }
        #myChart {
            max-width: 1000px; /* Tamaño intermedio */
            max-height: 500px; /* Tamaño intermedio */
        }
    </style>
</head>
<body>

    <div class="chart-container">
        <h2>Gráficos en Tiempo Real</h2>
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Aprobado', 'Rechazado', 'Pendiente'],
                datasets: [{
                    label: '# de Solicitudes',
                    data: [0, 0, 0], // Valores iniciales
                    backgroundColor: ['#83C0DF', '#a63ae6', '#fdfd96'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        // Función para actualizar el gráfico
        function updateChart() {
            fetch('get_permisos_data.php')
                .then(response => response.json())
                .then(data => {
                    myChart.data.datasets[0].data = [
                        data.Aprobado || 0,
                        data.Rechazado || 0,
                        data.Pendiente || 0
                    ];
                    myChart.update();
                })
                .catch(error => console.error('Error al actualizar el gráfico:', error));
        }

        // Actualiza el gráfico inmediatamente y luego cada 5 segundos
        updateChart();
        setInterval(updateChart, 5000);
    </script>

</body>
</html>
