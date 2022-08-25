<script>
    document.addEventListener('livewire:load', function () {

        var options = {
          series: [
            parseFloat(@this.top5Data[0]['total']),
            parseFloat(@this.top5Data[1]['total']),
            parseFloat(@this.top5Data[2]['total']),
            parseFloat(@this.top5Data[3]['total']),
            parseFloat(@this.top5Data[4]['total'])
          ],
          chart: {
          type: 'donut',
          height: 392
        },
        labels: [
            @this.top5Data[0]['product'],
            @this.top5Data[1]['product'],
            @this.top5Data[2]['product'],
            @this.top5Data[3]['product'],
            @this.top5Data[4]['product']
        ],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chartTop5"), options);
        chart.render();


        var optionsArea = {
          series: [{
          name: 'Venta del día',
          data: [
            parseFloat(@this.weekSales_Data[0]),
            parseFloat(@this.weekSales_Data[1]),
            parseFloat(@this.weekSales_Data[2]),
            parseFloat(@this.weekSales_Data[3]),
            parseFloat(@this.weekSales_Data[4]),
            parseFloat(@this.weekSales_Data[5]),
            parseFloat(@this.weekSales_Data[6])
          ]
        }],
          chart: {
          height: 380,
          type: 'area'
        },
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return '$' +val
          },
          offsetY: -5, 
          style:{
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          categories: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo']
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
        };

        var areaChart = new ApexCharts(document.querySelector("#areaChart"), optionsArea);
        areaChart.render();
      })
</script>



