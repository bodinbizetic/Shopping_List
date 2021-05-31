<!--
<link href="<?php /*echo base_url(); */?>/css/profile.css" rel="stylesheet">-->

<link href="<?php echo base_url(); ?>/css/singleGroup.css" rel="stylesheet">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script>
    $(document).ready(function(){

        drawSpending();
        drawLists();
        drawPopularYear();
        drawPopularMonth();

        function drawSpending() {
            //get the bar chart canvas
            var cData = JSON.parse(`<?php echo $chart_data_spending; ?>`);
            console.log(cData);
            var ctx = $("#spending-chart");

            //bar chart data
            var data = {
                labels: cData.label,
                datasets: [
                    {
                        //label: cData.label,
                        data: cData.data,
                        backgroundColor: [
                            "#F4A460",
                            "#CDA776",
                            "#DEB887",
                            "#A9A9A9",
                            "#DC143C",
                            "#F4A460",
                            "#2E8B57",
                            "#CDA776",
                            "#989898",
                            "#CB252B",
                            "#E39371",
                            "#1D7A46"
                        ],
                        borderColor: [
                            "#F4A460",
                            "#CDA776",
                            "#DEB887",
                            "#A9A9A9",
                            "#DC143C",
                            "#F4A460",
                            "#2E8B57",
                            "#CDA776",
                            "#989898",
                            "#CB252B",
                            "#E39371",
                            "#1D7A46"
                        ],
                        borderWidth: [1, 1, 1, 1, 1,1,1,1, 1, 1, 1,1,1]
                    }
                ]
            };

            //options
            var options = {
                responsive: true,
                legend: {
                    display: false
                }

            };

            //create bar Chart class object
            var chart1 = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options
            });
        }

        function drawLists() {
            //get the bar chart canvas
            var cData = JSON.parse(`<?php echo $chart_data_lists; ?>`);
            console.log(cData);
            var ctx = $("#lists-chart");

            //bar chart data
            var data = {
                labels: cData.label,
                datasets: [
                    {
                        //label: cData.label,
                        data: cData.data,
                        backgroundColor: [
                            "#DC143C",
                            "#CB252B",
                            "#F4A460",
                            "#2E8B57",
                            "#1D7A46",
                            "#CDA776",
                            "#CDA776",
                            "#989898",
                            "#E39371",
                            "#DEB887",
                            "#A9A9A9",
                        ],
                        borderColor: [
                            "#DC143C",
                            "#CB252B",
                            "#F4A460",
                            "#2E8B57",
                            "#1D7A46",
                            "#CDA776",
                            "#CDA776",
                            "#989898",
                            "#E39371",
                            "#DEB887",
                            "#A9A9A9",
                        ],
                        borderWidth: [1, 1, 1, 1, 1,1,1,1, 1, 1, 1,1,1]
                    }
                ]
            };

            //options
            var options = {
                responsive: true,
                legend: {
                    display: false
                }

            };

            //create bar Chart class object
            var chart1 = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options
            });
        }

        function drawPopularYear() {
            google.charts.load('current', { 'packages' : ['corechart', 'bar', 'timeline']});

            google.charts.setOnLoadCallback(function() {
                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                var rows = JSON.parse(`<?php echo $data_for_pie_year; ?>`);
                console.log(rows);
                data.addRows(rows);


                var options = {
                    'width':500,
                    'height':400
                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementsByClassName('year-popular')[0]);
                chart.draw(data, options);
            });
        }

        function drawPopularMonth() {
            google.charts.load('current', { 'packages' : ['corechart', 'bar', 'timeline']});

            google.charts.setOnLoadCallback(function() {
                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                var rows = JSON.parse(`<?php echo $data_for_pie_month; ?>`);
                console.log(rows);
                data.addRows(rows);

                // Set chart options
                var options = {
                    'width':500,
                    'height':400
                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementsByClassName('month-popular')[0]);
                chart.draw(data, options);
            });
        }

    });
</script>



<section id="profile">
    <div class="container">
        <div class="section-title">
            <h2>Info</h2>
        </div>
    </div>

    <div class="content">
        <div class="slide">
            <div class="div-img">
                <?php
                if(isset($group['image'])): ?>
                    <img src="<?php echo base_url(). '/groupUploads/'. $group['image']; ?>" class="avatar img-circle" style="border-radius: 50%">
                <?php else: ?>
                    <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle" style="border-radius: 50%">
                <?php endif; ?>
                <h3>
                    <?= $group['name'] ?>
                </h3>
                <h5>
                    <?= $group['description'] ?>
                </h5>
            </div>
            <div class="members">
                <div class="count">
                    <p><?php echo count($members); ?> members</p>
                    <hr>
                </div>
                <div class="list">
                    <ul>
                        <?php $i=0; foreach($members as $member): ?>
                        <li <?php if($inGroup[$i++]['type'] == '1') echo "class='bg-warning'" ?> >
                            <!--<img src="imgs/person1.jpg" class="avatar img-circle"> Nikola Milovanovic-->
                            <?php
                                echo $member['username'];
                            ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="statistic">
            <div class="row">
                <table class="table">
                    <caption>Monthly Spending / Monthly No Of Lists</caption>
                </table>
            </div>
            <div class="row">
                <div class="col col-sm-5">
                    <div class="spending">
                        <canvas id="spending-chart"></canvas>
                    </div>
                </div>
                <div class="col col-sm-5 offset-1">
                    <div class="lists">
                        <canvas id="lists-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table">
                    <caption>Most frequently requested YEAR / MONTH</caption>
                </table>
            </div>
            <div class="row">
                <div class="col col-sm-5">
                    <div class="year-popular"></div>
                </div>
                <div class="col col-sm-5 offset-1">
                    <div class="month-popular"></div>
                </div>
            </div>
        </div>
    </div>
</section>