function Pie() {
    return {
        chart: {
            width: 380,
            type: 'pie',
        },
        labels: [],
        responsive: [{
            breakpoint: 480,
            options: {
                charts: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    }

}