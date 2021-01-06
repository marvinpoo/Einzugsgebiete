<?php
// Add Shortcode
function bodenrichtwert_sc( $atts ) {
	/* Vars */
	//types
	$brwz   = 'brw_type';
	$ot     = 'ot_type';
	$bezirk = 'bezirk_type';

	//taxes
	$tot = 'ot_tax';
	$tbezirk = 'bezirk_tax';

	//years
	$year_latest = 'bodenrichtwerte_2020';

	$year_2020 = 'bodenrichtwerte_2020';
	$year_2019 = 'bodenrichtwerte_2019';
	$year_2018 = 'bodenrichtwerte_2018';
	$year_2017 = 'bodenrichtwerte_2017';
	$year_2016 = 'bodenrichtwerte_2016';
	$year_2015 = 'bodenrichtwerte_2015';

	// $year_slide = array('bodenrichtwerte_2019','bodenrichtwerte_2018','bodenrichtwerte_2017','bodenrichtwerte_2016','bodenrichtwerte_2015');

	//termcall
	$post_term_ot = get_the_terms($post->ID, $tot);
	$post_term_bezirk = get_the_terms($post->ID, $tbezirk);

	// Attributes
	$atts = shortcode_atts(
		array(
			'brwz'       => '',
			'ot'				 => '',
			'bezirk'		 => '',
			'jahr'       => '',
      'jahre'      => '',
      'jahrespan'  => '',
      'sort'       => '',
      'art'        => '',
		),
		$atts,
		'brw'
	);

	// BRWZ
	if (!empty($atts['brwz'])) {
		// without year(s)
		if(empty($atts['jahr']) && empty($atts['jahre']) && empty($atts['jahrespan'])) {
			$the_slug = $atts['brwz'];
			$a1 = array(
			  'name'        => $the_slug,
			  'post_type'   => $brwz,
			  'post_status' => 'publish',
			  'numberposts' => 1,
				'meta_key'		=> $year_latest,
			);
			$q1 = new WP_Query($a1);
			while ( $q1->have_posts()) {
				$q1->the_post();
				$currentPostID = get_the_id();
				return get_post_meta($currentPostID,$year_latest, true) . ' €/m<sup>2</sup>';
			}
		}

		// with year
		elseif (!empty($atts['jahr'])) {
			$the_slug = $atts['brwz'];
			$a1 = array(
			  'name'        => $the_slug,
			  'post_type'   => $brwz,
			  'post_status' => 'publish',
			  'numberposts' => 1,
				// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
			);
			$q1 = new WP_Query($a1);
			while ( $q1->have_posts()) {
				$q1->the_post();
				$currentPostID = get_the_id();
				$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $atts['jahr'], true);
				return $brwecho . ' €/m<sup>2 x</sup>';
			}
		}

		// with multiple years
		elseif ((!empty($atts['jahre'])) && ($atts['art'] == 'chart' || empty($atts['art'])))  {
			$atts['jahre'] = array_map( 'trim', str_getcsv( $atts['jahre'], ','));
			ob_start(); ?>
			<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>

			<canvas id="charttest"></canvas>
		  <script>
		  var ctx = document.getElementById('charttest').getContext('2d');
		  var myChart = new Chart(ctx, {
		      type: 'line',
		      data: {
		        // labels: ["1","2",],
		        labels: [<?php $year_atts = $atts['jahre']; foreach($year_atts AS $year) { print_r('"' . $year . '",'); }?>],
						datasets: [{
		            label: 'Max',
		            // data: [210,350,],
								data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['brwz'];
								$a1 = array(
								  'name'        => $the_slug,
								  'post_type'   => $brwz,
								  'post_status' => 'publish',
								  'numberposts' => 1,
									// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
								);
								$q1 = new WP_Query($a1);
								while ( $q1->have_posts()) {
									$q1->the_post();
									$currentPostID = get_the_id();

									foreach($year_atts AS $year) {
										$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
										print_r($brwecho . ',');
									}
								}?>],
		            backgroundColor: [
		              'rgba(0,0,0,0)', //mpw
		            ],
		            borderColor: [
		              'rgba(34,49,128,1)', //mpw
		            ],
		            borderWidth: 2
		        },
		        // {
		        //     label: 'Min',
		        //     data: [175,237,],
		        //     backgroundColor: [
		        //       'rgba(0,0,0,0)', //mpw
		        //     ],
		        //     borderColor: [
		        //       'rgba(189,17,1,1)', //mpw
		        //     ],
		        //     borderWidth: 2
		        // },
		      ]
		    },
		    options: {
					elements: {
						line: {
							tension: 0
						}
					},
		      legend: {
		        onHover: function(event, legendItem) {
		          document.getElementsByClassName("legendItem").style.cursor = 'pointer';
		        }
		      },
		      tooltips: {
		                enabled: true,
		                mode: 'single',
		                callbacks: {
		                    label: function(tooltipItems, data) {
		                        return ' ' + tooltipItems.yLabel + ' €/m²';
		                    }
		                }
		            },
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		      }
		    });
		  </script>
			<?php
			wp_reset_postdata();
			return ob_get_clean();
		}

		elseif (!empty($atts['jahre']) && $atts['art'] == "tabelle") {
			// code
		}// with yearspan

	} // BRWZ

	// OT
	elseif (!empty($atts['ot'])) {
		// empty year(s)
		if(empty($atts['jahr']) && empty($atts['jahre']) && empty($atts['jahrespan'])) {
			// empty sort = max
			if(empty($atts['sort']) || $atts['sort'] == 'max') {
				$the_slug = $atts['ot'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'DESC',
		      'meta_key'=>$year_latest,
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,$year_latest, true) . ' €/m<sup>2</sup>';
				}
			} elseif ($atts['sort'] == 'min') {
				$the_slug = $atts['ot'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'ASC',
		      'meta_key'=>$year_latest,
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,$year_latest, true) . ' €/m<sup>2</sup>';
				}
			}
		}
		// specific year
		if(!empty($atts['jahr']) && empty($atts['jahre']) && empty($atts['jahrespan'])) {
			// empty sort = max
			if(empty($atts['sort']) || $atts['sort'] == 'max') {
				$the_slug = $atts['ot'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'DESC',
		      'meta_key' => 'bodenrichtwerte_' . $atts['jahr'],
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,'bodenrichtwerte_' . $atts['jahr'], true) . ' €/m<sup>2</sup>';
				}
			} elseif ($atts['sort'] == 'min') {
				$the_slug = $atts['ot'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'ASC',
		      'meta_key' => 'bodenrichtwerte_' . $atts['jahr'],
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,'bodenrichtwerte_' . $atts['jahr'], true) . ' €/m<sup>2</sup>';
				}
			}
		}

		// with multiple years
		elseif (!empty($atts['jahre']) && ($atts['art'] == 'chart' || empty($atts['art']))) {
			// without sort, show min AND max
			if (empty($atts['sort'])) {
				$atts['jahre'] = array_map( 'trim', str_getcsv( $atts['jahre'], ','));
				ob_start(); ?>
				<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
			  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>

				<canvas id="charttest2"></canvas>
			  <script>
			  var ctx = document.getElementById('charttest2').getContext('2d');
			  var myChart = new Chart(ctx, {
			      type: 'line',
			      data: {
			        // labels: ["1","2",],
			        labels: [<?php $year_atts = $atts['jahre']; foreach($year_atts AS $year) { print_r('"' . $year . '",'); }?>],
							datasets: [{
			            label: 'Max',
			            // data: [210,350,],
									data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['ot'];
									foreach($year_atts AS $year) {
									$a1 = array(
									  'post_type'   => 'brw_type',
									  'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'DESC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
								      array(
									      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
									      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
									      'terms' 	 => $the_slug,
								      )
							      )

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
			            backgroundColor: [
			              'rgba(0,0,0,0)', //mpw
			            ],
			            borderColor: [
			              'rgba(34,49,128,1)', //mpw
			            ],
			            borderWidth: 2
			        },
			        {
			            label: 'Min',
			            data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['ot'];
									foreach($year_atts AS $year) {
									$a1 = array(
									  'post_type'   => 'brw_type',
									  'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'ASC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
								      array(
									      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
									      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
									      'terms' 	 => $the_slug,
								      )
							      )

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
			            backgroundColor: [
			              'rgba(0,0,0,0)', //mpw
			            ],
			            borderColor: [
			              'rgba(189,17,1,1)', //mpw
			            ],
			            borderWidth: 2
			        },
			      ]
			    },
			    options: {
						elements: {
							line: {
								tension: 0
							}
						},
			      legend: {
			        onHover: function(event, legendItem) {
			          document.getElementsByClassName("legendItem").style.cursor = 'pointer';
			        }
			      },
			      tooltips: {
			                enabled: true,
			                mode: 'single',
			                callbacks: {
			                    label: function(tooltipItems, data) {
			                        return ' ' + tooltipItems.yLabel + ' €/m²';
			                    }
			                }
			            },
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        }
			      }
			    });
			  </script>
				<?php
				wp_reset_postdata();
				return ob_get_clean();
			}

			// Sort Max
			elseif ($atts['sort'] == 'max') {
				$atts['jahre'] = array_map( 'trim', str_getcsv( $atts['jahre'], ','));
				ob_start(); ?>
				<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
			  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>

				<canvas id="charttest3"></canvas>
			  <script>
			  var ctx = document.getElementById('charttest3').getContext('2d');
			  var myChart = new Chart(ctx, {
			      type: 'line',
			      data: {
			        // labels: ["1","2",],
			        labels: [<?php $year_atts = $atts['jahre']; foreach($year_atts AS $year) { print_r('"' . $year . '",'); }?>],
							datasets: [{
			            label: 'Max',
			            // data: [210,350,],
									data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['ot'];
									foreach($year_atts AS $year) {
									$a1 = array(
									  'post_type'   => 'brw_type',
									  'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'DESC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
								      array(
									      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
									      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
									      'terms' 	 => $the_slug,
								      )
							      )

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
			            backgroundColor: [
			              'rgba(0,0,0,0)', //mpw
			            ],
			            borderColor: [
			              'rgba(34,49,128,1)', //mpw
			            ],
			            borderWidth: 2
			        },
			      ]
			    },
			    options: {
						elements: {
							line: {
								tension: 0
							}
						},
			      legend: {
			        onHover: function(event, legendItem) {
			          document.getElementsByClassName("legendItem").style.cursor = 'pointer';
			        }
			      },
			      tooltips: {
			                enabled: true,
			                mode: 'single',
			                callbacks: {
			                    label: function(tooltipItems, data) {
			                        return ' ' + tooltipItems.yLabel + ' €/m²';
			                    }
			                }
			            },
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        }
			      }
			    });
			  </script>
				<?php
				wp_reset_postdata();
				return ob_get_clean();
			}

			// sort min
			elseif ($atts['sort'] == 'min') {
				$atts['jahre'] = array_map( 'trim', str_getcsv( $atts['jahre'], ','));
				ob_start(); ?>
				<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
			  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>

				<canvas id="charttest4"></canvas>
			  <script>
			  var ctx = document.getElementById('charttest4').getContext('2d');
			  var myChart = new Chart(ctx, {
			      type: 'line',
			      data: {
			        // labels: ["1","2",],
			        labels: [<?php $year_atts = $atts['jahre']; foreach($year_atts AS $year) { print_r('"' . $year . '",'); }?>],
							datasets: [{
			            label: 'Min',
			            data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['ot'];
									foreach($year_atts AS $year) {
									$a1 = array(
									  'post_type'   => 'brw_type',
									  'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'ASC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
								      array(
									      'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
									      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
									      'terms' 	 => $the_slug,
								      )
							      )

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
			            backgroundColor: [
			              'rgba(0,0,0,0)', //mpw
			            ],
			            borderColor: [
			              'rgba(189,17,1,1)', //mpw
			            ],
			            borderWidth: 2
			        },
			      ]
			    },
			    options: {
						elements: {
							line: {
								tension: 0
							}
						},
			      legend: {
			        onHover: function(event, legendItem) {
			          document.getElementsByClassName("legendItem").style.cursor = 'pointer';
			        }
			      },
			      tooltips: {
			                enabled: true,
			                mode: 'single',
			                callbacks: {
			                    label: function(tooltipItems, data) {
			                        return ' ' + tooltipItems.yLabel + ' €/m²';
			                    }
			                }
			            },
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        }
			      }
			    });
			  </script>
				<?php
				wp_reset_postdata();
				return ob_get_clean();
			}

		}

	}

	// BEZIRK
	elseif (!empty($atts['bezirk'])) {
		// empty year(s)
		if(empty($atts['jahr']) && empty($atts['jahre']) && empty($atts['jahrespan'])) {
			// empty sort = max
			if(empty($atts['sort']) || $atts['sort'] == 'max') {
				$the_slug = $atts['bezirk'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'DESC',
		      'meta_key'=>$year_latest,
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,$year_latest, true) . ' €/m<sup>2</sup>';
				}
			} elseif ($atts['sort'] == 'min') {
				$the_slug = $atts['bezirk'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'ASC',
		      'meta_key'=>$year_latest,
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,$year_latest, true) . ' €/m<sup>2</sup>';
				}
			}
		}
		// specific year
		if(!empty($atts['jahr']) && empty($atts['jahre']) && empty($atts['jahrespan'])) {
			// empty sort = max
			if(empty($atts['sort']) || $atts['sort'] == 'max') {
				$the_slug = $atts['bezirk'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'DESC',
		      'meta_key' => 'bodenrichtwerte_' . $atts['jahr'],
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,'bodenrichtwerte_' . $atts['jahr'], true) . ' €/m<sup>2</sup>';
				}
			} elseif ($atts['sort'] == 'min') {
				$the_slug = $atts['bezirk'];
				$a1 = array(
					'posts_per_page' => 1,
		      'post_type' => 'brw_type', // you can change it according to your custom post type
		      'orderby'=>'meta_value_num',
		      'order'=>'ASC',
		      'meta_key' => 'bodenrichtwerte_' . $atts['jahr'],
		      'tax_query' => array(
			      array(
				      'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
				      'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
				      'terms' 	 => $the_slug,
			      )
		      )
				);
				$q1 = new WP_Query($a1);
				while ( $q1->have_posts()) {
					$q1->the_post();
					$currentPostID = get_the_id();
					return get_post_meta($currentPostID,'bodenrichtwerte_' . $atts['jahr'], true) . ' €/m<sup>2</sup>';
				}
			}
		}
		// with multiple years
		elseif (!empty($atts['jahre']) && ($atts['art'] == 'chart' || empty($atts['art']))) {
			// without sort, show min AND max
			if (empty($atts['sort'])) {
				$atts['jahre'] = array_map( 'trim', str_getcsv( $atts['jahre'], ','));
				ob_start(); ?>
				<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>

				<canvas id="charttest5"></canvas>
				<script>
				var ctx = document.getElementById('charttest5').getContext('2d');
				var myChart = new Chart(ctx, {
						type: 'line',
						data: {
							// labels: ["1","2",],
							labels: [<?php $year_atts = $atts['jahre']; foreach($year_atts AS $year) { print_r('"' . $year . '",'); }?>],
							datasets: [{
									label: 'Max',
									// data: [210,350,],
									data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['bezirk'];
									foreach($year_atts AS $year) {
									$a1 = array(
										'post_type'   => 'brw_type',
										'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'DESC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
											array(
												'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
												'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
												'terms' 	 => $the_slug,
											)
										)

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
									backgroundColor: [
										'rgba(0,0,0,0)', //mpw
									],
									borderColor: [
										'rgba(34,49,128,1)', //mpw
									],
									borderWidth: 2
							},
							{
									label: 'Min',
									data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['bezirk'];
									foreach($year_atts AS $year) {
									$a1 = array(
										'post_type'   => 'brw_type',
										'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'ASC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
											array(
												'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
												'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
												'terms' 	 => $the_slug,
											)
										)

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
									backgroundColor: [
										'rgba(0,0,0,0)', //mpw
									],
									borderColor: [
										'rgba(189,17,1,1)', //mpw
									],
									borderWidth: 2
							},
						]
					},
					options: {
						elements: {
							line: {
								tension: 0
							}
						},
						legend: {
							onHover: function(event, legendItem) {
								document.getElementsByClassName("legendItem").style.cursor = 'pointer';
							}
						},
						tooltips: {
											enabled: true,
											mode: 'single',
											callbacks: {
													label: function(tooltipItems, data) {
															return ' ' + tooltipItems.yLabel + ' €/m²';
													}
											}
									},
							scales: {
									yAxes: [{
											ticks: {
													beginAtZero:true
											}
									}]
							}
						}
					});
				</script>
				<?php
				wp_reset_postdata();
				return ob_get_clean();
			}

			// Sort Max
			elseif ($atts['sort'] == 'max') {
				$atts['jahre'] = array_map( 'trim', str_getcsv( $atts['jahre'], ','));
				ob_start(); ?>
				<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>

				<canvas id="charttest6"></canvas>
				<script>
				var ctx = document.getElementById('charttest6').getContext('2d');
				var myChart = new Chart(ctx, {
						type: 'line',
						data: {
							// labels: ["1","2",],
							labels: [<?php $year_atts = $atts['jahre']; foreach($year_atts AS $year) { print_r('"' . $year . '",'); }?>],
							datasets: [{
									label: 'Max',
									// data: [210,350,],
									data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['bezirk'];
									foreach($year_atts AS $year) {
									$a1 = array(
										'post_type'   => 'brw_type',
										'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'DESC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
											array(
												'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
												'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
												'terms' 	 => $the_slug,
											)
										)

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
									backgroundColor: [
										'rgba(0,0,0,0)', //mpw
									],
									borderColor: [
										'rgba(34,49,128,1)', //mpw
									],
									borderWidth: 2
							},
						]
					},
					options: {
						elements: {
							line: {
								tension: 0
							}
						},
						legend: {
							onHover: function(event, legendItem) {
								document.getElementsByClassName("legendItem").style.cursor = 'pointer';
							}
						},
						tooltips: {
											enabled: true,
											mode: 'single',
											callbacks: {
													label: function(tooltipItems, data) {
															return ' ' + tooltipItems.yLabel + ' €/m²';
													}
											}
									},
							scales: {
									yAxes: [{
											ticks: {
													beginAtZero:true
											}
									}]
							}
						}
					});
				</script>
				<?php
				wp_reset_postdata();
				return ob_get_clean();
			}

			// sort min
			elseif ($atts['sort'] == 'min') {
				$atts['jahre'] = array_map( 'trim', str_getcsv( $atts['jahre'], ','));
				ob_start(); ?>
				<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha256-arMsf+3JJK2LoTGqxfnuJPFTU4hAK57MtIPdFpiHXOU=" crossorigin="anonymous"></script>

				<canvas id="charttest7"></canvas>
				<script>
				var ctx = document.getElementById('charttest7').getContext('2d');
				var myChart = new Chart(ctx, {
						type: 'line',
						data: {
							// labels: ["1","2",],
							labels: [<?php $year_atts = $atts['jahre']; foreach($year_atts AS $year) { print_r('"' . $year . '",'); }?>],
							datasets: [{
									label: 'Min',
									data: [<?php $year_atts = $atts['jahre']; $the_slug = $atts['bezirk'];
									foreach($year_atts AS $year) {
									$a1 = array(
										'post_type'   => 'brw_type',
										'post_status' => 'publish',
										'posts_per_page' => 1,
										'orderby' => 'meta_value_num',
										'order' => 'ASC',
										'meta_key' => 'bodenrichtwerte_' . $year,
										'tax_query' => array(
											array(
												'taxonomy' => 'bezirk_tax', // you can change it according to your taxonomy
												'field' 	 => 'slug', // this can be 'term_id', 'slug' & 'name'
												'terms' 	 => $the_slug,
											)
										)

										// 'meta_key'		=> 'bodenrichtwerte_' . $atts['jahr'],
									);
									$q1 = new WP_Query($a1);
									while ( $q1->have_posts()) {
										$q1->the_post();
										$currentPostID = get_the_id();


											$brwecho = get_post_meta($currentPostID,'bodenrichtwerte_' . $year, true);
											print_r($brwecho . ',');
										}
									}?>],
									backgroundColor: [
										'rgba(0,0,0,0)', //mpw
									],
									borderColor: [
										'rgba(189,17,1,1)', //mpw
									],
									borderWidth: 2
							},
						]
					},
					options: {
						elements: {
							line: {
								tension: 0
							}
						},
						legend: {
							onHover: function(event, legendItem) {
								document.getElementsByClassName("legendItem").style.cursor = 'pointer';
							}
						},
						tooltips: {
											enabled: true,
											mode: 'single',
											callbacks: {
													label: function(tooltipItems, data) {
															return ' ' + tooltipItems.yLabel + ' €/m²';
													}
											}
									},
							scales: {
									yAxes: [{
											ticks: {
													beginAtZero:true
											}
									}]
							}
						}
					});
				</script>
				<?php
				wp_reset_postdata();
				return ob_get_clean();
			}

		}
	}
	// code ende

}
add_shortcode( 'brw', 'bodenrichtwert_sc' );
?>

<?php

// function brw_get_brw_by_brwz( $slug, $post_type = $brwz, $unique = true ){
//     $args=array(
//         'name' => $slug,
//         'post_type' => $post_type,
//         'post_status' => 'publish',
//         'posts_per_page' => 1
//     );
//     $my_posts = get_posts( $args );
//     if( $my_posts ) {
//         //echo 'ID on the first post found ' . $my_posts[0]->ID;
//         if( $unique ){
//             return $my_posts[ 0 ];
//         }else{
//             return $my_posts;
//         }
//     }
//     return false;
// }

?>
