<head>

</head>


<body>
    <div class="main-body" style="height: 90vh;">
        <div class="btns border border-red h-100 d-flex justify-content-center align-items-center  ">
            <button id="ready" class="btn btn-primary">ready</button>
            <button id="call" class="btn btn-secondary ml-2">call</button>
            <button id="dispose" class="btn btn-info  ml-2">dispose</button>
            <button id="stop" class="btn btn-danger ml-2">stop</button>
        </div>
    </div>
</body>

<script>
    const obj = {

    }
    $("#ready").click(function() {
        console.log($('#ready').text());
        let state = $('#ready').text();
        const time = Date.now();
        obj[state] = time
        console.log('Current time: ' + obj);
        post(obj)
    });
    $("#call").click(function() {

        let state = $('#call').text();
        const time = Date.now();
        obj[state] = time
        console.log('Current time: ' + obj);
        post(obj)
    });
    $("#dispose").click(function() {
        let state = $('#dispose').text();
        const time = Date.now();
        obj[state] = time
        console.log('Current time: ' + obj);
        post(obj)
        
    });
    $("#stop").click(function() {
        let state = $('#stop').text();
        const time = Date.now();
        obj[state] = time
        console.log('Current time: ' + obj);
        post(obj);
        obj = {}
    });
    const post = async (data) => {
        console.log(data)
        let response = await fetch("http://localhost:3000/redis/create", {
            method: "POST",
            mode: "no-cors",
            headers: {
                "Access-Control-Allow-Origin": "*",
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
             // body data
        })
        console.log(response)
    }
</script>