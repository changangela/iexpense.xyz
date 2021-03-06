var xhr= new XMLHttpRequest();
xhr.open("GET", "../walletjson.php");
xhr.setRequestHeader("Content-Type","application/json");
xhr.addEventListener("load",function () {
    
    var data = JSON.parse(this.responseText);
    var personal = data.personal;
    var technology= data.technology;
    var groceries= data.groceries;
    var entertainment= data.entertainment;
    var total = data.totalexpense;

    var chart = new CanvasJS.Chart("wallet-chart", {
        
        title: {
            text: "Expenses per category",
            fontFamily: "Ubuntu",
            fontColor: "Black",
            fontSize: 20

        },
        animationEnabled: true,
        axisY: {
            tickThickness: 0,
            lineThickness: 0,
            valueFormatString: " ",
            gridThickness: 0,
            labelFontSize: 18,                   
        },
        axisX: {
            tickThickness: 0,
            lineThickness: 0,
            labelFontSize: 18,
            labelFontColor: "Black"

        },
        data: [
        {
            indexLabelFontSize: 14,
            toolTipContent: "<span style='\"'color: {color};'\"'><strong>{indexLabel}</strong></span><span style='\"'font-size: 20px; color:black '\"'><strong> {y}%</strong></span>",

            indexLabelPlacement: "inside",
            indexLabelFontColor: "black",
            indexLabelFontWeight: 200,
            indexLabelFontFamily: "Ubuntu",
            color: "#62C9C3",
            type: "bar",
            dataPoints: [ 
                { y: 100*entertainment/total, label: (100*entertainment/total).toFixed(2) + "%", indexLabel: "Entertainment" },
                { y: 100*groceries/total, label: (100*groceries/total).toFixed(2) + "%", indexLabel: "Groceries" },
                { y: 100*personal/total, label: (100*personal/total).toFixed(2) + "%", indexLabel: "Personal" },
                { y: 100*technology/total, label: (100*technology/total).toFixed(2) + "%", indexLabel: "Technology" },                
            ]
        }
        ]
    });

    chart.render();
});

xhr.send();
