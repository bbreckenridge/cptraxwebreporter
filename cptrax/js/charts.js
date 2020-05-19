<script type="text/javascript">
	<?php $x = $numOfDays; while ($x >= 1) { echo 'var day'.$x.' = moment().subtract('.$x.', \'days\').format(\'MMM Do\');'; $x--; } echo 'var day0 = moment().format(\'MMM Do\');'; ?>
	new Chart(document.getElementById("ad-line"), {
		type: 'line',
		data: {
			labels: [<?php $x = $numOfDays; $arrayLineDays = array(); while ($x >= 0) { array_push($arrayLineDays, 'day'.$x); $x--; } $daysList = implode(',',$arrayLineDays); print_r($daysList); ?>],
			datasets: [
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($adLineUserQueryResults[$x][1].','); $x--; } echo addslashes($adLineUserQueryResults[0][1]); ?>],
					label: "User Changes",
					borderColor: "#3cba9f",
					fill: false,
				},
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($adLineGroupQueryResults[$x][1].','); $x--; } echo addslashes($adLineGroupQueryResults[0][1]); ?>],
					label: "Group Changes",
					borderColor: "#c45850",
					fill: false,
				}, 
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($adLineCompQueryResults[$x][1].','); $x--; } echo addslashes($adLineCompQueryResults[0][1]); ?>],
					label: "Computer Changes",
					borderColor: "#e8c3b9",
					fill: false,
				}, 
			]
		},
		options: {
			title: {
				display: true,
				text: 'User, Group, and Computer Changes Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			},
			scales: {
				xAxes: [{
					ticks: {
						autoSkip: true,
						maxTicksLimit: 20,
						fontSize: 14
					}
				}],
				yAxes: [{
					ticks: {
						autoSkip: true,
						fontSize: 14
					}
				}]
			},
			legend: {
      				labels: {
        				fontSize: 14
      				}
  			}
		}
	});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("ad-bar-1"), {
			type: 'bar',
			data: {
			  labels: [<?php echo '"'.addslashes($adBar1QueryResults[0][0]).'"' ?>, <?php echo '"'.addslashes($adBar1QueryResults[1][0]).'"' ?>, <?php echo '"'.addslashes($adBar1QueryResults[2][0]).'"' ?>, <?php echo '"'.addslashes($adBar1QueryResults[3][0]).'"' ?>, <?php echo '"'.addslashes($adBar1QueryResults[4][0]).'"' ?>],
			  datasets: [
				{
				  label: 'Last ' + <?php echo addslashes($numOfDays); ?> + ' Days Changes',
				  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
				  data: [<?php echo '"'.$adBar1QueryResults[0][1].'"' ?>,<?php echo '"'.$adBar1QueryResults[1][1].'"' ?>,<?php echo '"'.$adBar1QueryResults[2][1].'"' ?>,<?php echo '"'.$adBar1QueryResults[3][1].'"' ?>,<?php echo '"'.$adBar1QueryResults[4][1].'"' ?>],
				}
			  ]
			},
			options: {
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 12
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 12
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'Active Directory Changes by Domain Controller Last ' + <?php echo addslashes($numOfDays); ?> + ' Days (TOP 5)',
				fontSize: 16
			  },
			  legend: {display:false}
			}
		});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("ad-bar-2"), {
			type: 'horizontalBar',
			data: {
			  labels: ["Created", "Deleted", "Disabled", "Enabled", "Locked"],
			  datasets: [
				{
				  label: 'Last ' + <?php echo addslashes($numOfDays); ?> + ' Days User Status Changes',
				  backgroundColor: ["#3cba9f", "#c45850", "#3e95cd", "#8e5ea2", "#e8c3b9"],
				  data: [<?php echo $adHBarQueryCreatedResults[0][0] ?>,<?php echo $adHBarQueryDeletedResults[0][0] ?>,<?php echo $adHBarQueryDisabledResults[0][0] ?>,<?php echo $adHBarQueryEnabledResults[0][0] ?>,<?php echo $adHBarQueryLockedResults[0][0] ?>]
				}
			  ]
			},
			options: {
			  legend: { display:false },
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 14
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 14
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'User Status Changes Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			  }
			}
		});
</script>

<script type="text/javascript">
	new Chart(document.getElementById("ad-pie"), {
		type: 'pie',
		data: {
		  labels: ["Group Creates", "Group Deletes", "Users Added", "Users Removed"],
		  datasets: [{
			label: 'Group Changes Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
			backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#c45850","#e8c3b9"],
			data: [<?php echo $adPieQueryGroupCreatesResults[0][0] ?>,<?php echo $adPieQueryGroupDeletesResults[0][0] ?>,<?php echo $adPieQueryGroupMemAddResults[0][0] ?>,<?php echo $adPieQueryGroupMemRemResults[0][0] ?>]
		  }]
		},
		options: {
		  title: {
			display: true,
			text: 'Group Changes Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
			fontSize: 16
		  },
		  legend: { 
			labels: { 
				fontSize: 14
			}
		  }
		}
	});
</script>

<script type="text/javascript">
	<?php $x = $numOfDays; while ($x >= 1) { echo 'var day'.$x.' = moment().subtract('.$x.', \'days\').format(\'MMM Do\');'; $x--; } echo 'var day0 = moment().format(\'MMM Do\');'; ?>
	new Chart(document.getElementById("fs-line"), {
		type: 'line',
		data: {
			labels: [<?php $x = $numOfDays; $arrayLineDays = array(); while ($x >= 0) { array_push($arrayLineDays, 'day'.$x); $x--; } $daysList = implode(',',$arrayLineDays); print_r($daysList); ?>],
			datasets: [
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($fsLineCreateQueryResults[$x][1].','); $x--; } echo addslashes($fsLineCreateQueryResults[0][1]); ?>],
					label: "Creates",
					borderColor: "#3cba9f",
					fill: false
				},
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($fsLineDeleteQueryResults[$x][1].','); $x--; } echo addslashes($fsLineDeleteQueryResults[0][1]); ?>],
					label: "Deletes",
					borderColor: "#c45850",
					fill: false
				},
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($fsLineRenameQueryResults[$x][1].','); $x--; } echo addslashes($fsLineRenameQueryResults[0][1]); ?>],
					label: "Renames/Moves",
					borderColor: "#3e95cd",
					fill: false
				},				
				{ 
					data: [
						<?php echo addslashes($fsLinePermQueryResults[0][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[1][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[2][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[3][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[4][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[5][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[6][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[7][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[8][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[9][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[10][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[11][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[12][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[13][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[14][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[15][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[16][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[17][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[18][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[19][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[20][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[21][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[21][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[23][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[24][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[25][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[26][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[27][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[28][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[29][1])?>,
						<?php echo addslashes($fsLinePermQueryResults[30][1])?>
					],
					label: "Permissions Changes",
					borderColor: "#e8c3b9",
					fill: false
				}, 
			]
		},
		options: {
			title: {
				display: true,
				text: 'All File System Activity Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			},
			scales: {
				xAxes: [{
					ticks: {
						autoSkip: true,
						maxTicksLimit: 20,
						fontSize: 14
					}
				}],
				yAxes: [{
					ticks: {
						autoSkip: true,
						fontSize: 14
					}
				}]
			},
			legend: {
      				labels: {
        				fontSize: 14
      				}
  			}
		}
	});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("fs-bar-1"), {
			type: 'bar',
			data: {
			  labels: [<?php echo '"'.addslashes($fsBarTop5QueryResults[0][0]).'"' ?>, <?php echo '"'.addslashes($fsBarTop5QueryResults[1][0]).'"' ?>, <?php echo '"'.addslashes($fsBarTop5QueryResults[2][0]).'"' ?>, <?php echo '"'.addslashes($fsBarTop5QueryResults[3][0]).'"' ?>, <?php echo '"'.addslashes($fsBarTop5QueryResults[4][0]).'"' ?>],
			  datasets: [
				{
				  label: 'Last ' + <?php echo addslashes($numOfDays); ?> + ' Days File Activity',
				  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
				  data: [<?php echo '"'.$fsBarTop5QueryResults[0][1].'"' ?>,<?php echo '"'.$fsBarTop5QueryResults[1][1].'"' ?>,<?php echo '"'.$fsBarTop5QueryResults[2][1].'"' ?>,<?php echo '"'.$fsBarTop5QueryResults[3][1].'"' ?>,<?php echo '"'.$fsBarTop5QueryResults[4][1].'"' ?>]
				}
			  ]
			},
			options: {
			  legend: { display:false },
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 12
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 12
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'Top 5 File System Users Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			  }
			}
		});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("fs-bar-2"), {
			type: 'horizontalBar',
			data: {
			  labels: [<?php echo '"'.addslashes($fsHBarTop5QueryResults[0][0]).'"' ?>, <?php echo '"'.addslashes($fsHBarTop5QueryResults[1][0]).'"' ?>, <?php echo '"'.addslashes($fsHBarTop5QueryResults[2][0]).'"' ?>, <?php echo '"'.addslashes($fsHBarTop5QueryResults[3][0]).'"' ?>, <?php echo '"'.addslashes($fsHBarTop5QueryResults[4][0]).'"' ?>],
			  datasets: [
				{
				  label: 'Last ' + <?php echo addslashes($numOfDays); ?> + ' Days File System Changes',
				  backgroundColor: ["#3cba9f", "#c45850", "#3e95cd", "#8e5ea2", "#e8c3b9"],
				  data: [<?php echo $fsHBarTop5QueryResults[0][1] ?>,<?php echo $fsHBarTop5QueryResults[1][1] ?>,<?php echo $fsHBarTop5QueryResults[1][2] ?>,<?php echo $fsHBarTop5QueryResults[1][3] ?>,<?php echo $fsHBarTop5QueryResults[1][4] ?>]
				}
			  ]
			},
			options: {
			  legend: { display:false },
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 14
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 14
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'File System Changes per Server Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			  }
			}
		});
</script>

<script type="text/javascript">
	new Chart(document.getElementById("fs-pie"), {
		type: 'pie',
		data: {
		  labels: ["Writes", "Renames/Moves", "Creates", "Deletes", "Permissions Changes"],
		  datasets: [{
			label: "User Account Status",
			backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#c45850","#e8c3b9"],
			data: [<?php echo $pieWritesResults[0][0] ?>,<?php echo $pieRenamesResults[0][0] ?>,<?php echo $pieCreatesResults[0][0] ?>,<?php echo $pieDeletesResults[0][0] ?>,<?php echo $piePermsResults[0][0] ?>]
		  }]
		},
		options: {
		  title: {
			display: true,
			text: 'File System Events for the Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
			fontSize: 16
		  },
		  legend: { 
			labels: { 
				fontSize: 14
			}
		  }
		}
	});
</script>

<script type="text/javascript">
	<?php $x = $numOfDays; while ($x >= 1) { echo 'var day'.$x.' = moment().subtract('.$x.', \'days\').format(\'MMM Do\');'; $x--; } echo 'var day0 = moment().format(\'MMM Do\');'; ?>
	new Chart(document.getElementById("ll-line"), {
		type: 'line',
		data: {
			labels: [<?php $x = $numOfDays; $arrayLineDays = array(); while ($x >= 0) { array_push($arrayLineDays, 'day'.$x); $x--; } $daysList = implode(',',$arrayLineDays); print_r($daysList); ?>],
			datasets: [
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($lineSuccAuthsResults[$x][1].','); $x--; } echo addslashes($lineSuccAuthsResults[0][1]); ?>],
					label: "Logons",
					borderColor: "#3cba9f",
					fill: false
				},
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($lineFailedAuthsResults[$x][1].','); $x--; } echo addslashes($lineFailedAuthsResults[0][1]); ?>],
					label: "Failed Logons",
					borderColor: "#c45850",
					fill: false
				}, 
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($lineLockoutsResults[$x][1].','); $x--; } echo addslashes($lineLockoutsResults[0][1]); ?>],
					label: "Account Lockouts",
					borderColor: "#e8c3b9",
					fill: false
				}, 
			]
		},
		options: {
			title: {
				display: true,
				text: 'Authentication Events Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			},
			scales: {
				xAxes: [{
					ticks: {
						autoSkip: true,
						maxTicksLimit: 20,
						fontSize: 14
					}
				}],
				yAxes: [{
					ticks: {
						autoSkip: true,
						fontSize: 14
					}
				}]
			},
			legend: {
      				labels: {
        				fontSize: 14
      				}
  			}
		}
	});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("ll-bar-1"), {
			type: 'bar',
			data: {
			  labels: [<?php echo '"'.addslashes($barAuthsResults[0][0]).'"' ?>, <?php echo '"'.addslashes($barAuthsResults[1][0]).'"' ?>, <?php echo '"'.addslashes($barAuthsResults[2][0]).'"' ?>, <?php echo '"'.addslashes($barAuthsResults[3][0]).'"' ?>, <?php echo '"'.addslashes($barAuthsResults[4][0]).'"' ?>],
			  datasets: [
				{
				  label: 'Last ' + <?php echo addslashes($numOfDays); ?> + ' Days Authentications',
				  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
				  data: [<?php echo '"'.$barAuthsResults[0][1].'"' ?>,<?php echo '"'.$barAuthsResults[1][1].'"' ?>,<?php echo '"'.$barAuthsResults[2][1].'"' ?>,<?php echo '"'.$barAuthsResults[3][1].'"' ?>,<?php echo '"'.$barAuthsResults[4][1].'"' ?>]
				}
			  ]
			},
			options: {
			  legend: { display: false },
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 12
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 12
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'Top 5 Authenticators for the Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			  }
			}
		});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("ll-bar-2"), {
			type: 'horizontalBar',
			data: {
			  labels: [<?php echo '"'.addslashes($llHBarQueryResults[0][0]).'"' ?>, <?php echo '"'.addslashes($llHBarQueryResults[1][0]).'"' ?>, <?php echo '"'.addslashes($llHBarQueryResults[2][0]).'"' ?>, <?php echo '"'.addslashes($llHBarQueryResults[3][0]).'"' ?>, <?php echo '"'.addslashes($llHBarQueryResults[4][0]).'"' ?>],
			  datasets: [
				{
				  label: 'Last ' + <?php echo addslashes($numOfDays); ?> + ' Days Failed Authentications',
				  backgroundColor: ["#3cba9f", "#c45850", "#3e95cd", "#8e5ea2", "#e8c3b9"],
				  data: [<?php echo $llHBarQueryResults[0][1] ?>,<?php echo $llHBarQueryResults[1][1] ?>,<?php echo $llHBarQueryResults[2][1] ?>,<?php echo $llHBarQueryResults[3][1] ?>,<?php echo $llHBarQueryResults[4][1] ?>]
				}
			  ]
			},
			options: {
			  legend: { display: false },
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 14
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 14
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'Top 5 Failed Authenticators for the Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			  }
			}
		});
</script>

<script type="text/javascript">
	new Chart(document.getElementById("ll-pie"), {
		type: 'pie',
		data: {
		  labels: [<?php echo '"'.addslashes($llPieTop5QueryResults[0][0]).'"' ?>, <?php echo '"'.addslashes($llPieTop5QueryResults[1][0]).'"' ?>, <?php echo '"'.addslashes($llPieTop5QueryResults[2][0]).'"' ?>, <?php echo '"'.addslashes($llPieTop5QueryResults[3][0]).'"' ?>, <?php echo '"'.addslashes($llPieTop5QueryResults[4][0]).'"' ?>],
		  datasets: [{
			label: 'Authentication Events Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
			backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#c45850","#e8c3b9"],
			data: [<?php echo $llPieTop5QueryResults[0][1] ?>,<?php echo $llPieTop5QueryResults[1][1] ?>,<?php echo $llPieTop5QueryResults[2][1] ?>,<?php echo $llPieTop5QueryResults[3][1] ?>,<?php echo $llPieTop5QueryResults[4][1] ?>]
		  }]
		},
		options: {
		  title: {
			display: true,
			text: 'Authentications per Server Last ' + <?php echo addslashes($numOfDays); ?> + ' Days (TOP 5)',
			fontSize: 16
		  },
		  legend: { 
			labels: { 
				fontSize: 14
			}
		  }
		}
	});
</script>

<script type="text/javascript">
	<?php $x = $numOfDays; while ($x >= 1) { echo 'var day'.$x.' = moment().subtract('.$x.', \'days\').format(\'MMM Do\');'; $x--; } echo 'var day0 = moment().format(\'MMM Do\');'; ?>
	new Chart(document.getElementById("gpo-line"), {
		type: 'line',
		data: {
			labels: [<?php $x = $numOfDays; $arrayLineDays = array(); while ($x >= 0) { array_push($arrayLineDays, 'day'.$x); $x--; } $daysList = implode(',',$arrayLineDays); print_r($daysList); ?>],
			datasets: [
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($gpoLineCreateQueryResults[$x][1].','); $x--; } echo addslashes($gpoLineCreateQueryResults[0][1]); ?>],
					label: "GPO Creates",
					borderColor: "#3cba9f",
					fill: false
				},
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($gpoLineDeleteQueryResults[$x][1].','); $x--; } echo addslashes($gpoLineDeleteQueryResults[0][1]); ?>],
					label: "GPO Deletes",
					borderColor: "#c45850",
					fill: false
				},
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($gpoLineLinkQueryResults[$x][1].','); $x--; } echo addslashes($gpoLineLinkQueryResults[0][1]); ?>],
					label: "GPO Modified",
					borderColor: "#3e95cd",
					fill: false
				},				
				{ 
					data: [<?php $x = $numOfDays; while ($x >= 1) { echo addslashes($gpoLineModifyQueryResults[$x][1].','); $x--; } echo addslashes($gpoLineModifyQueryResults[0][1]); ?>],
					label: "GPO Linked",
					borderColor: "#e8c3b9",
					fill: false
				}, 
			]
		},
		options: {
			title: {
				display: true,
				text: 'All GPO Activity Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				fontSize: 16
			},
			scales: {
				xAxes: [{
					ticks: {
						autoSkip: true,
						maxTicksLimit: 20,
						fontSize: 14
					}
				}],
				yAxes: [{
					ticks: {
						autoSkip: true,
						fontSize: 14
					}
				}]
			},
			legend: {
      				labels: {
        				fontSize: 14
      				}
  			}
		}
	});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("gpo-bar-1"), {
			type: 'bar',
			data: {
			  labels: [<?php echo '"'.addslashes($gpoBarPerDCQueryResults[0][0]).'"' ?>, <?php echo '"'.addslashes($gpoBarPerDCQueryResults[1][0]).'"' ?>, <?php echo '"'.addslashes($gpoBarPerDCQueryResults[2][0]).'"' ?>, <?php echo '"'.addslashes($gpoBarPerDCQueryResults[3][0]).'"' ?>, <?php echo '"'.addslashes($gpoBarPerDCQueryResults[4][0]).'"' ?>],
			  datasets: [
				{
				  label: 'GPO Changes Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
				  data: [<?php echo '"'.$gpoBarPerDCQueryResults[0][1].'"' ?>,<?php echo '"'.$gpoBarPerDCQueryResults[1][1].'"' ?>,<?php echo '"'.$gpoBarPerDCQueryResults[2][1].'"' ?>,<?php echo '"'.$gpoBarPerDCQueryResults[3][1].'"' ?>,<?php echo '"'.$gpoBarPerDCQueryResults[4][1].'"' ?>]
				}
			  ]
			},
			options: {
			  legend: { display: false },
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 12
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 12
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'GPO Changes by Domain Controller Last ' + <?php echo addslashes($numOfDays); ?> + ' Days (TOP 5)',
				fontSize: 16
			  }
			}
		});
</script>

<script type="text/javascript">
		new Chart(document.getElementById("gpo-bar-2"), {
			type: 'horizontalBar',
			data: {
			  labels: [<?php echo '"'.addslashes($gpoBar2PerUserQueryResults[0][0]).'"' ?>, <?php echo '"'.addslashes($gpoBar2PerUserQueryResults[1][0]).'"' ?>, <?php echo '"'.addslashes($gpoBar2PerUserQueryResults[2][0]).'"' ?>, <?php echo '"'.addslashes($gpoBar2PerUserQueryResults[3][0]).'"' ?>, <?php echo '"'.addslashes($gpoBar2PerUserQueryResults[4][0]).'"' ?>],
			  datasets: [
				{
				  label: 'GPO Changes Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
				  backgroundColor: ["#3cba9f", "#c45850", "#3e95cd", "#8e5ea2", "#e8c3b9"],
				  data: [<?php echo $gpoBar2PerUserQueryResults[0][1] ?>,<?php echo $gpoBar2PerUserQueryResults[1][1] ?>,<?php echo $gpoBar2PerUserQueryResults[2][1] ?>,<?php echo $gpoBar2PerUserQueryResults[3][1] ?>,<?php echo $gpoBar2PerUserQueryResults[4][1] ?>]
				}
			  ]
			},
			options: {
			  legend: { display: false },
			  scales: {
				  xAxes: [{
					ticks: {
						fontSize: 14
					}
				  }],
				  yAxes: [{
					ticks: {
						fontSize: 14
					}
				  }]
			  },
			  title: {
				display: true,
				text: 'GPO Changes by User Last ' + <?php echo addslashes($numOfDays); ?> + ' Days (TOP 5)',
				fontSize: 16
			  }
			}
		});
</script>

<script type="text/javascript">
	new Chart(document.getElementById("gpo-pie"), {
		type: 'pie',
		data: {
		  labels: ["GPO Creates", "GPO Deletes", "GPO Modified", "GPO Linked"],
		  datasets: [{
			label: "User Account Status",
			backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#c45850","#e8c3b9"],
			data: [<?php echo $sumGPOCreatedResults[0][0] ?>,<?php echo $sumGPODeletedResults[0][0] ?>,<?php echo $sumGPOModsResults[0][0] ?>,<?php echo $sumGPOLinksResults[0][0] ?>]
		  }]
		},
		options: {
		  title: {
			display: true,
			text: 'Group Policy Events for the Last ' + <?php echo addslashes($numOfDays); ?> + ' Days',
			fontSize: 16
		  },
		  legend: { 
			labels: { 
				fontSize: 14
			}
		  }
		}
	});
</script>