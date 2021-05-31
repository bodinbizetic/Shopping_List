
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>/css/profile.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- javascript -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

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

<script>
    $(document).ready(function() {
        $("input[name='username']").val("<?php echo $user['username']; ?>");
        $("input[name='fullName']").val("<?php echo $user['fullName']; ?>");
        $("input[name='phone']").val("<?php echo $user['phone']; ?>");
        $("input[name='password']").val("<?php echo $user['password']; ?>");
        $("input[name='email']").val("<?php echo $user['email']; ?>");
    });

    function showImage() {
        file_input = document.querySelector("input[type='file']");
        if (file_input.files && file_input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#group-img')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(file_input.files[0]);
        }
    }

</script>

<section id="profile">
    <div class="container">
        <div class="section-title">
            <h2>My Profile</h2>
        </div>
    </div>
</section>

<div class="content">
    <div class="row">
        <div class="col-sm-3">
            <div class="slide">
                <div class="my-form">
                    <form method="post" action="/profile/edit"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">
                                <input type="file" name="image" id="image" align="center" onchange="showImage()" style="display:none;"/>
                                <?php
                                if(isset($user['image'])): ?>
                                    <img id="group-img" src="<?php echo base_url(). '/uploads/'. $user['image']; ?>">
                                <?php else: ?>
                                    <img  id="group-img" src="<?php echo base_url(). '/images/profile/person.jpg'; ?>">
                                <?php endif; ?>
                            </label>
                            <h3>
                                <?= $user['fullName'] ?>
                            </h3>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-prepend"><i class="input-group-text fa fa-user"></i></span>
                                <input type="text" name="username" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-prepend"><i class="input-group-text fa fa-male"></i></span>
                                <input type="text" name="fullName" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-prepend"><i class="input-group-text fa fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-prepend"><i class="input-group-text fa fa-lock"></i></span>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="input-group">
                                <span class="input-group-prepend"><i class="input-group-text fa fa-phone"></i></span>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                        </div>
                        <input type="submit" value="Save changes" class="btn btn-success btn-block">
                        <br>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <span class="title">Most frequently requested YEAR</span>
                </div>
                <div class="card-body">
                    <div class="year-popular"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <span class="title">Most frequently requested MONTH</span>
                </div>
                <div class="card-body">
                    <div class="month-popular"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">&nbsp;
            <?php if(isset($errors)) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php
                    echo $errors. "<br>";
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
        </div>
        <div class="col-sm-4 offset-3">
            <div class="card">
                <div class="card-header">
                    <span class="title">Monthly Spending</span>
                </div>
                <div class="card-body">
                    <div class="spending">
                        <canvas id="spending-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <span class="title">Monthly No Of Lists</span>
                </div>
                <div class="card-body">
                    <div class="lists">
                        <canvas id="lists-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
