const ctx = document.getElementById('myChart');

fetch("chartScript.php")
  .then((response) => {
    return response.json();
  })

  .then((data) => {
    createChart(data, 'bar')
  });

  var_dump(data);

function createChart(chartData, type){
  new Chart(ctx, {
    type: type,
    data: {
      labels: chartData.map(row => row.month),
      datasets: [
        {
        label: '# volunteers',
        data: chartData.map(row => row.unique_volunteers),
        borderWidth: 1
      },
    {
      label: 'total hours',
      data: chartData.map(row => row.total_hours),
      borderWidth: 1
    }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}