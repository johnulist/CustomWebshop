<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    echo $html->script('highcharts', array('inline' => false));
?>
<div class="block-titel">Dashboard</div>

<div class="dashboard">

    <div class="bestelcount"><div class="number"><?php echo count($bestellingen); ?></div> bestellingen<br /> deze maand</div>
    <div class="inkomstencount"><div class="number"><?php echo $number->currency($inkomsten); ?></div> inkomsten<br /> deze maand</div>
    <div class="factuurcount"><div class="number"><?php echo $openstaand; ?></div> openstaande facturen<br /> t.w.v. <?php echo $number->currency($debetsaldo); ?></div>
    
    <div id="graph" class="graph"></div>

</div>




<script type="text/javascript">
		
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'graph',
                defaultSeriesType: 'line',
                marginRight: 0,
                width: 770,
                marginBottom: 25
            },
            title: {
                text: 'Bestellingen in <?php echo strftime("%B"); ?>',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: [<?php echo implode(",", array_keys($graph_bestellingen)); ?>]
            },
            yAxis: {
                title: {
                    text: 'Aantal'
                },
                tickInterval: 1,
                min: 0,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +' <?php echo strftime("%B"); ?>: '+ this.y +'';
                },
                crosshairs: true
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Alle bestellingen',
                data: [<?php echo implode(",", $graph_bestellingen); ?>]
            }, {
                name: 'Betaalde bestellingen',
                data: [<?php echo implode(",", $graph_betaald); ?>]
            }]
        });


    });
		
</script>
