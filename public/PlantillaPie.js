function Pie() {
    return {
        chart: {
            width: 380,
            type: 'pie',
        },
        labels: ['TeamA', 'Team B', 'Team C', 'Team D', 'Team E'],
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