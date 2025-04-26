const ctx = document.getElementById('myChart');

fetch("chartScript.php")
  .then((response) => {
    return response.json();
  })

  .then((data) => {
    createChart(data, graphType)
  });


function createChart(chartData, type){
  new Chart(ctx, {
    type: type,
    data: {
      labels: chartData.map(row => row.month),
      datasets: [
        {
        label: '# volunteers',
        borderColor: '#7E0B07',
        backgroundColor: '#7E0B07',
        data: chartData.map(row => row.unique_volunteers),
        borderWidth: 1
      },
    {
      label: 'total hours',
      borderColor: '#CFA118',
      backgroundColor: '#CFA118',
      data: chartData.map(row => row.total_hours),
      borderWidth: 1
    }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}