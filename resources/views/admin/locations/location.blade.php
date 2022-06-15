<script language="JavaScript" type="application/javascript">
    var iconBase = 'http://www.gstatic.com/mapspro/images/stock/995-biz-car-dealer.png';
    var lat;
    var lng;
    var loc;
    var newLatLng;

    $(document).ready(function () {
        gMap = new google.maps.Map(document.getElementById('map'));
        gMap.setZoom(13);
        gMap.setCenter(new google.maps.LatLng(36.4032918, 54.9562727));
        gMap.setMapTypeId(google.maps.MapTypeId.ROADMAP);


        marker = new google.maps.Marker({
            position: new google.maps.LatLng('', ''),
            icon: iconBase,
            map: gMap
        });

//            get id driver

        $("select.select").change(function () {
            var selectedCountry = $(".select option:selected").val();

            setInterval(function () {


                $.getJSON('{{url('/admin/location')}}/' + selectedCountry + '/edit', function (data) {
                    lat = parseFloat(data[0].latitude);
                    lng = parseFloat(data[0].longitude);
                    newLatLng = new google.maps.LatLng(lat, lng);
                    marker.setPosition(newLatLng);

                }, 3000);
            });
        });
    });
</script>
<style>
    .select {
        margin: 30px 10px 10px 10px;
    }

    h4 {
        padding: 30px 20px 10px 20px;
    }

    hr {
        border: 1px solid #292C33;
    }
</style>

<style>
    #driver_id {
        border: 1px solid #0067a5;
        font-size: 13px;
        color: black;
        font-family: Tahoma;
    }
</style>

<div class="container-fluid">
    <hr>
    <div class="col-md-12 col-sm-12 col-xs-12" id="map" style="height: 550px; ">
    </div>
</div>