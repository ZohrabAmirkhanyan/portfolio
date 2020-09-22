<?php
class zga_zip_api
{
    public $endpoint     = "https://api.ziprecruiter.com/jobs/v1/";
    
    public function get_default_args() {
        return array(
            'api_key'       => '',
            'search'        => 'PPS',
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
   public function format_args( $args ) {
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
    function format_job( $raw_job ) {
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
    function response( $total_pages = 0, $total_jobs = 0, $jobs = array(),$results = array() ) {
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
    public function get_jobs( $args ) {
        //$args           = self::format_args( wp_parse_args( $args, self::get_default_args() ) );
        $args           = $this->format_args( wp_parse_args( $args, $this->get_default_args() ) );
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
                    return $this->response( 0, 0, array(), array());
                }
            } else {
                return $this->response( 0, 0, array(),array() );
            }
            
        }
        //print_r($result); die;
        
        $total_jobs     = absint( $results->total_jobs );
       
        $total_pages    = ceil( $total_jobs / $args['jobs_per_page'] );
        
        foreach ( $results->jobs as $result ) {
            $jobs[] = $this->format_job($result);
        }
        
        //return $jobs;
       // return $this->endpoint;
       // return http_build_query( $args, '', '&' ); //self::response( $total_pages, $total_jobs, $jobs );
        return $this->response( $total_pages, $total_jobs, $jobs, $results );
        
        

    }
    
}