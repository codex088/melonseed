<?php 
if (! function_exists('myCurl')) {
  function myCurl($endpoint, $method) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    if ($method == 'post' || $method == 'POST') {
      curl_setopt($ch, CURLOPT_POST, true);
    }
    curl_setopt($ch, CURLOPT_POST, false);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
     
    // Set HTTP Header for POST request 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/x-www-form-urlencoded'
      // 'Content-Length: ' . strlen($data_string)
    ));
     
    // Submit the POST request
    $result = curl_exec($ch);
     
    // Close cURL session handle
    curl_close($ch);
    
    return json_decode($result);
  }
}

if (! function_exists('getArrLocationFromIP')) {
  function getArrLocationFromIP($ip_address) {
    $IPSTACK_KEY = env('IPSTACK_KEY', '0baa013cafd0e1879edc45c96d1018b1');
    $endpoint = 'http://api.ipstack.com/' . $ip_address . '?access_key=' . $IPSTACK_KEY;
    
    return myCurl($endpoint, 'post');
    // {#222 ▼
    //   +"ip": "104.247.132.212"
    //   +"type": "ipv4"
    //   +"continent_code": "NA"
    //   +"continent_name": "North America"
    //   +"country_code": "US"
    //   +"country_name": "United States"
    //   +"region_code": "CA"
    //   +"region_name": "California"
    //   +"city": "Fremont"
    //   +"zip": "94536"
    //   +"latitude": 37.5625
    //   +"longitude": -122.0004
    //   +"location": {#217 ▼
    //  +"geoname_id": null
    //  +"capital": "Washington D.C."
    //  +"languages": array:1 [▼
    //    0 => {#218 ▼
    //    +"code": "en"
    //    +"name": "English"
    //    +"native": "English"
    //    }
    //  ]
    //  +"country_flag": "http://assets.ipstack.com/flags/us.svg"
    //  +"country_flag_emoji": "🇺🇸"
    //  +"country_flag_emoji_unicode": "U+1F1FA U+1F1F8"
    //  +"calling_code": "1"
    //  +"is_eu": false
    //   }
    // }
  }
}

if (! function_exists('calcTotalRate')) {
  function calcTotalRate($array) {
    $sum = 0;
    foreach ($array as $key => $value) {
      $sum += $value->rate;
    }
    if (count($array)) {
      return $sum / count($array);
    } else {
      return null;
    }
  }
}

if (! function_exists('catchYearFromDateTime')) {
  function catchYearFromDateTime($date_time) {
    return explode('-', $date_time)[0];
  }
}

if (! function_exists('getFullName')) {
  function getFullName($first_name, $last_name) {
    return $first_name . ' ' . $last_name;
  }
}

if (! function_exists('getUserSimpleLocationFromIP')) {
  function getUserSimpleLocationFromIP($ip) {
    return getArrLocationFromIP($ip)->city . ', ' . getArrLocationFromIP($ip)->region_code;
  }
}

if (! function_exists('getCurrentLatLonKeywardFromIP')) {
  function getCurrentLatLonKeywardFromIP($ip) {
    return getArrLocationFromIP($ip)->latitude . ',' . getArrLocationFromIP($ip)->longitude;
  }
}

if (! function_exists('getLatFromIP')) {
  function getLatFromIP($ip) {
    return getArrLocationFromIP($ip)->latitude;
  }
}

if (! function_exists('getLonFromIP')) {
  function getLonFromIP($ip) {
    return getArrLocationFromIP($ip)->longitude;
  }
}

if (! function_exists('getCityListFromIP')) {
  function getCityListFromIP($ip) {
    $country_code = getArrLocationFromIP($ip)->country_code;
    $region_name = getArrLocationFromIP($ip)->region_name;

    $BATTUTA_KEY = env('BATTUTA_KEY', '37a6a5e83edcc17aea06193d0df8825b');
    $endpoint = 'http://battuta.medunes.net/api/city/'. $country_code .'/search/?region='. $region_name .'&key=' . $BATTUTA_KEY;
    return myCurl($endpoint, 'get');
  }
}

if (! function_exists('checkAvailableAge')) {
  function checkAvailableAge($age_range, $age) {
    return strpos($age_range, $age);
  }
}

if (! function_exists('getAvailableDayObj')) {
  function getAvailableDayObj($business_hours, $day) {
    if ($business_hours) {
      $hours_obj = json_decode($business_hours);
      switch ($day) {
        case 'monday': return $hours_obj->monday; break;
        case 'tuesday': return $hours_obj->tuesday; break;
        case 'wednesday': return $hours_obj->wednesday; break;
        case 'thursday': return $hours_obj->thursday; break;
        case 'friday': return $hours_obj->friday; break;
        case 'saturday': return $hours_obj->saturday; break;
        case 'sunday': return $hours_obj->sunday; break;
        default: return null; break;
      }
    } else {
      return null;
    }
  }
}

if (! function_exists('displayAgeRange')) {
  function displayAgeRange($age_range) {
    $age_pattern = '';
    // if (strpos($age_range, 'age1')) {
    //   $age_pattern .= '<div class="age-pattern">1-6 months</div>';
    // }
    if (strpos($age_range, 'age1')) {
      $age_pattern .= '<div class="age-pattern">1 Year</div>';
    }
    if (strpos($age_range, 'age2')) {
      $age_pattern .= '<div class="age-pattern">1-3 Years</div>';
    }
    if (strpos($age_range, 'age3')) {
      $age_pattern .= '<div class="age-pattern">4-7 Years</div>';
    }
    if (strpos($age_range, 'age4')) {
      $age_pattern .= '<div class="age-pattern">8-10 Years</div>';
    }
    if (strpos($age_range, 'age5')) {
      $age_pattern .= '<div class="age-pattern">11-13 Years</div>';
    }
    if (strpos($age_range, 'age6')) {
      $age_pattern .= '<div class="age-pattern">14-16 Years</div>';
    }
    // if (strpos($age_range, 'age8')) {
    //   $age_pattern .= '<div class="age-pattern">18+ Years</div>';
    // }
    
    echo $age_pattern;
  }
}

if (! function_exists('getBookingStatus')) {
  function getBookingStatus($status_code) {
    $status = '';
    switch ($status_code) {
      case '0': $status = 'Processing'; break;
      case '1': $status = 'Completed'; break;
      case '2': $status = 'Canceled'; break;
      case '3': $status = 'Expired'; break;
      default: $status = 'Processing'; break;
    }

    return $status;
  }
}

if (! function_exists('getGeoCodeFromAddress')) {
  function getGeoCodeFromAddress($address) {
    $GOOGLE_MAP_API_KEY = env('GOOGLE_MAP_API_KEY', 'AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc');
    // $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=' . $GOOGLE_MAP_API_KEY;
    $address_keyward = str_replace(" ", "+", $address);
    $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address_keyward . '&key=' . $GOOGLE_MAP_API_KEY;
    $response = myCurl($endpoint, 'get');
    
    return $response;
  }
}

if (! function_exists('getGeoLocationFromAddress')) {
  function getGeoLocationFromAddress($address) {
    $response = getGeoCodeFromAddress($address);
    $results['status'] = false;
    if ($response->status == 'OK') {
      $results['status'] = true;
      $results['address'] = $response->results[0]->formatted_address;
      $results['location'] = $response->results[0]->geometry->location;
      $results['latitude'] = $response->results[0]->geometry->location->lat;
      $results['longitude'] = $response->results[0]->geometry->location->lng;
    } else {
      $results['status'] = false;
      $results['error'] = $response->status;
    }

    return $results;
  }
}

if (! function_exists('getLatLngFromAddress')) {
  function getLatLngFromAddress($address) {
    $response = getGeoCodeFromAddress($address);
    $results['status'] = false;
    if ($response->status == 'OK') {
      $results['status'] = true;
      $results['result'] = $response->results[0]->geometry->location;
    } else {
      $results['status'] = false;
      $results['result'] = $response->status;
    }
    
    return $results;
  }
}

if (! function_exists('getFormattedAddressFromAddress')) {
  function getFormattedAddressFromAddress($address) {
    $response = getGeoCodeFromAddress($address);
    $results['status'] = false;
    if ($response->status == 'OK') {
      $results['status'] = true;
      $results['result'] = $response->results[0]->formatted_address;
    } else {
      $results['status'] = false;
      $results['result'] = $response->status;
    }

    return $results;
  }
}

if (! function_exists('distance')) {
  function distance($lat1, $lng1, $lat2, $lng2, $unit, $round) {
    $result = 0;
    if (($lat1 == $lat2) && ($lng1 == $lng2)) {
      $result = 0;
    }
    else {
      $theta = $lng1 - $lng2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);

      if ($unit == "K") {
        $result = ($miles * 1.609344);
      } else if ($unit == "N") {
        $result = ($miles * 0.8684);
      } else {
        $result = $miles;
      }
      
      $round = intval($round);
      if ($round && is_numeric($round)) {
        return round($result, $round);
      } else {
        return $result;
      }
    }
  }
}

if (! function_exists('distanceWithMyIP2ProviderPlace')) {
  function distanceWithMyIP2ProviderPlace($ip, $lat2, $lng2, $unit, $round) {
    if (!$ip) {
      return null;
    }

    $lat1 = getArrLocationFromIP($ip)->latitude;
    $lng1 = getArrLocationFromIP($ip)->longitude;

    return distance($lat1, $lng1, $lat2, $lng2, $unit, $round);
  }
}

if (! function_exists('displayBusinessHoursPattern')) {
  function displayBusinessHoursPattern($business_hours_str) {
    $business_hours_str = '{"monday":{"available":true,"start":"10:00","end":"17:00"},"tuesday":{"available":false,"start":"10:00","end":"17:00"},"wednesday":{"available":false,"start":"10:00","end":"17:00"},"thursday":{"available":false,"start":"10:00","end":"17:00"},"friday":{"available":false,"start":"10:00","end":"17:00"},"saturday":{"available":true,"start":"10:00","end":"17:00"},"sunday":{"available":true,"start":"10:00","end":"17:00"}}';
    $business_hours = json_decode($business_hours_str);
    $business_hours_pattern = '';
    if ($business_hours->monday->available) {
      $business_hours_pattern .= '<div class="business-hours-pattern">' . 
                                    '<div class="pattern-day">Monday</div>' .
                                    '<div class="pattern-start">'. $business_hours->monday->start .'</div>' .
                                    '<div class="pattern-to">~</div>' .
                                    '<div class="pattern-end">'. $business_hours->monday->end .'</div>' .
                                  '</div>';
    }
    if ($business_hours->tuesday->available) {
      $business_hours_pattern .= '<div class="business-hours-pattern">' . 
                                    '<div class="pattern-day">Tuesday</div>' .
                                    '<div class="pattern-start">'. $business_hours->tuesday->start .'</div>' .
                                    '<div class="pattern-to">~</div>' .
                                    '<div class="pattern-end">'. $business_hours->tuesday->end .'</div>' .
                                  '</div>';
    }
    if ($business_hours->wednesday->available) {
      $business_hours_pattern .= '<div class="business-hours-pattern">' . 
                                    '<div class="pattern-day">Wednesday</div>' .
                                    '<div class="pattern-start">'. $business_hours->wednesday->start .'</div>' .
                                    '<div class="pattern-to">~</div>' .
                                    '<div class="pattern-end">'. $business_hours->wednesday->end .'</div>' .
                                  '</div>';
    }
    if ($business_hours->thursday->available) {
      $business_hours_pattern .= '<div class="business-hours-pattern">' . 
                                    '<div class="pattern-day">Thursday</div>' .
                                    '<div class="pattern-start">'. $business_hours->thursday->start .'</div>' .
                                    '<div class="pattern-to">~</div>' .
                                    '<div class="pattern-end">'. $business_hours->thursday->end .'</div>' .
                                  '</div>';
    }
    if ($business_hours->friday->available) {
      $business_hours_pattern .= '<div class="business-hours-pattern">' . 
                                    '<div class="pattern-day">Friday</div>' .
                                    '<div class="pattern-start">'. $business_hours->friday->start .'</div>' .
                                    '<div class="pattern-to">~</div>' .
                                    '<div class="pattern-end">'. $business_hours->friday->end .'</div>' .
                                  '</div>';
    }
    if ($business_hours->saturday->available) {
      $business_hours_pattern .= '<div class="business-hours-pattern">' . 
                                    '<div class="pattern-day">Saturday</div>' .
                                    '<div class="pattern-start">'. $business_hours->saturday->start .'</div>' .
                                    '<div class="pattern-to">~</div>' .
                                    '<div class="pattern-end">'. $business_hours->saturday->end .'</div>' .
                                  '</div>';
    }
    if ($business_hours->sunday->available) {
      $business_hours_pattern .= '<div class="business-hours-pattern">' . 
                                    '<div class="pattern-day">Sunday</div>' .
                                    '<div class="pattern-start">'. $business_hours->sunday->start .'</div>' .
                                    '<div class="pattern-to">~</div>' .
                                    '<div class="pattern-end">'. $business_hours->sunday->end .'</div>' .
                                  '</div>';
    }
    if (!$business_hours_pattern) {
      $business_hours = '<div class="business-hours-pattern"> Business is not available. </div>';
    }
    echo $business_hours_pattern;
  }
}