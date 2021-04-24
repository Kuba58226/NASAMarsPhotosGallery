function handleButtonClick(event) {
    event.preventDefault()

    let rover_name = document.getElementById('rover_name').value;
    let camera_name = document.getElementById('camera_name').value;
    let date = document.getElementById('date').value;
    let date_from = document.getElementById('date_from').value;
    let date_to = document.getElementById('date_to').value;

    let url = 'http://127.0.0.1:8000/api/images';
    let params = [rover_name,camera_name,date,date_from,date_to];
    let params_names = ['rover_name','camera_name','date','date_from','date_to'];
    let first = true;
    for (let i=0;i<params.length;i++) {
        if (params[i] !== '') {
            if (first===true) {
                url=url+'?'+params_names[i]+'='+params[i];
                first=false;
            }
            else {
                url=url+'&'+params_names[i]+'='+params[i];
            }
        }
    }

    document.getElementById('content').innerHTML = "";
    fetch(url, {
        method: "GET",
        headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'},
    })
    .then(response => response.json())
    .then(data => {
        if (typeof data.images !== 'undefined') {
            let array = data.images;
            let stop_condition = array.length;
            let div = document.getElementById('content');
            for (let i=0;i<stop_condition;i++) {
                let row = document.createElement('div');
                row.append(document.createElement('p').innerText = data.images[i].rover_name);
                row.append(document.createElement('p').innerText = data.images[i].camera_name);
                row.append(document.createElement('p').innerText = data.images[i].date);
                let img = document.createElement('IMG');
                img.src = data.images[i].img_src;
                row.append(img);
                div.append(row)
            }
        }
    })
}

function handleButtonClick1(event) {
    event.preventDefault()

    let rover_name = document.getElementById('rover').value;
    let camera_name = document.getElementById('camera').value;
    let date = document.getElementById('date2').value;
    let image_url = document.getElementById('image_url').value;

    let url = 'http://127.0.0.1:8000/api/image';
    let params = [rover_name,camera_name,date,image_url];
    let params_names = ['rover','camera','date','image_url'];
    let first = true;
    for (let i=0;i<params.length;i++) {
        if (params[i] !== '') {
            if (first===true) {
                url=url+'?'+params_names[i]+'='+params[i];
                first=false;
            }
            else {
                url=url+'&'+params_names[i]+'='+params[i];
            }
        }
    }
    console.log(url)

    document.getElementById('content2').innerHTML = "";
    fetch(url, {
        method: "GET",
        headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'},
    })
    .then(response => response.json())
    .then(data => {
        if (typeof data.images !== 'undefined') {
            let array = data.images;
            let stop_condition = array.length;
            let div = document.getElementById('content2');
            for (let i=0;i<stop_condition;i++) {
                let row = document.createElement('div');
                row.append(document.createElement('p').innerText = data.images[i].rover_name);
                row.append(document.createElement('p').innerText = data.images[i].camera_name);
                row.append(document.createElement('p').innerText = data.images[i].date);
                let img = document.createElement('IMG');
                img.src = data.images[i].img_src;
                row.append(img);
                div.append(row)
            }
        }
    })
}