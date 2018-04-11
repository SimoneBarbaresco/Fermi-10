<html>
    <script>
        function richiedi_dati(){
            let xhr= new XMLHttpRequest();
            xhr.onreadystatechange= function() {
                if (this.readyState==4 && this.status==200) {
                    geolocalizzazione = JSON.parse(this.responseText);
                }
            };
            xhr.open(
                "GET",
                'http://ip-api.com/json',
                false);
            
            xhr.send();
        }

        function registra_dati(){
            let xhr= new XMLHttpRequest();
            xhr.onreadystatechange= function() {
                if (this.readyState==4 && this.status==200) {
                    response = this.responseText;
                }
            };
            xhr.open(
                "GET",
                `scrivi_dati.php?status=${geolocalizzazione.status}&country=${geolocalizzazione.country}&region=${geolocalizzazione.regionName}&city=${geolocalizzazione.city}&zip=${geolocalizzazione.zip}&lat=${geolocalizzazione.lat}&lon=${geolocalizzazione.lon}&timezone=${geolocalizzazione.timezone}&isp=${geolocalizzazione.isp}&IP=${geolocalizzazione.IP}`,
                false);
            
            xhr.send();
        }

        let geolocalizzazione= 0;
        let response;
        richiedi_dati();
        registra_dati();
        window.location='panoramica.php';
    </script>
</html>