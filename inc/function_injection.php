<?php function brw_chartinject() { ?>
  <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>
<?php } ?>
<?php
  function brw_charter_calc() { ?>
  <canvas id="charttest"></canvas>
  <script>
  var ctx = document.getElementById('charttest').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        // labels: ["1","2",],

        labels: [<?php $year_atts = $atts['jahre'];
        foreach($year_atts AS $year) {
          print_r('"' . $year . '",');
        }?>],

        datasets: [{
            label: 'Max',
            data: [210,350,],
            backgroundColor: [
              'rgba(0,0,0,0)', //mpw
            ],
            borderColor: [
              'rgba(34,49,128,1)', //mpw
            ],
            borderWidth: 2
        },
        // {
        //     label: 'Min',
        //     data: [175,237,],
        //     backgroundColor: [
        //       'rgba(0,0,0,0)', //mpw
        //     ],
        //     borderColor: [
        //       'rgba(189,17,1,1)', //mpw
        //     ],
        //     borderWidth: 2
        // },
      ]
    },
    options: {
      legend: {
        onHover: function(event, legendItem) {
          document.getElementsByClassName("legendItem").style.cursor = 'pointer';
        }
      },
      tooltips: {
                enabled: true,
                mode: 'single',
                callbacks: {
                    label: function(tooltipItems, data) {
                        return ' ' + tooltipItems.yLabel + ' €/m²';
                    }
                }
            },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
      }
    });
  </script>
<?php } ?>
