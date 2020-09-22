<?php

class zga_zip_api_rss
{
    public $endpoint     = "https://api.ziprecruiter.com/jobs/v1/";
    
    public function get_default_args_rss() {
        return array(
            'api_key'       => '',
            'search'        => 'seo',
            'location'      => 'USA',
            'jobs_per_page' => 5,
            'page'          => 1,
            'radius_miles'  => 20,
            'days_ago'      => 30,
            'refine_by_salary'=>1
            
        );
    }
    
    /**
     * Format args before sending them to the api
     * @param  array $args
     * @return array
     */
    public function format_args_rss( $args ) {
        foreach ( $args as $key => $value ) {
            if ( method_exists( __CLASS__, 'format_arg_' . strtolower( $key ) ) ) {
                $args[ $key ] = call_user_func( __CLASS__ . "::format_arg_" . strtolower( $key ), $value );
            }
        }
        return $args;
    }
    
    /**
     * Return job in standard format
     * @param  array $raw_job
     * @return object
     */
    function format_job_rss( $raw_job ) {
        $job = array(
            'title'           => sanitize_text_field( $raw_job->name ),
            'company'         => sanitize_text_field( $raw_job->hiring_company->name ),
            'tagline'         => sanitize_text_field( $raw_job->snippet  ),
            'url'             => esc_url_raw( $raw_job->url ),
            'location'        => sanitize_text_field( $raw_job->location ),
            'latitude'        => '',
            'longitude'       => '',
            'type'            => '',
            'type_slug'       => '',
            'timestamp'       => strtotime( $raw_job->posted_time ),
            'link_attributes' => array(),
            //'logo'            => apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ),
            'salary_max'      => sanitize_text_field( $raw_job->salary_max ),
            'salary_min'      => sanitize_text_field( $raw_job->salary_min )
            
        );
        
        return (object) $job;
    }
    /**
     * ihgiuygiuygiu
     * */
    function response_rss( $total_pages = 0, $total_jobs = 0, $jobs = array(),$results = array() ) {
        return array(
            'total_pages' => $total_pages,
            'total_jobs'  => $total_jobs,
            'result'     =>  $results,
            'jobs'        => $jobs
            
        );
    }
    
    /**
     * Get jobs from the API
     * @return array()
     */
    public function get_jobs_rss( $args ) {
        //$args           = self::format_args_rss( wp_parse_args( $args, self::get_default_args_rss() ) );
        $args           = $this->format_args_rss( wp_parse_args( $args, $this->get_default_args_rss() ) );
        $transient_name = 'ziprecruiter_' . md5( json_encode( $args ) );
        $total_pages    = 0;
        $total_jobs     = 0;
        $jobs           = array();
        
        
        
        
        if ( false === ( $results = get_transient( $transient_name ) ) || true ) {
            $results = array();
            $result  = wp_remote_get( $this->endpoint . '?' . http_build_query( $args, '', '&' ), array( 'timeout' => 10 ) );
            //  $result  = wp_remote_get( self::$endpoint . '?' . http_build_query( $args, '', '&' ), array( 'timeout' => 10 ) );
            
            if ( ! is_wp_error( $result ) && ! empty( $result['body'] ) ) {
                $results = json_decode( $result['body'] );
                
                if ( $results && ! empty( $results->success ) ) {
                    set_transient( $transient_name, $results, ( 60 * 60 * 24 ) );
                } else {
                    return $this->response_rss( 0, 0, array(), array());
                }
            } else {
                return $this->response_rss( 0, 0, array(),array() );
            }
            
        }
        //print_r($result); die;
        
        $total_jobs     = absint( $results->total_jobs );
        
        $total_pages    = ceil( $total_jobs / $args['jobs_per_page'] );
        
        foreach ( $results->jobs as $result ) {
            $jobs[] = $this->format_job_rss($result);
        }
        
        //return $jobs;
        // return $this->endpoint;
        // return http_build_query( $args, '', '&' ); //self::response_rss( $total_pages, $total_jobs, $jobs );
        return $this->response_rss( $total_pages, $total_jobs, $jobs, $results );
        
        
        
    }
}

