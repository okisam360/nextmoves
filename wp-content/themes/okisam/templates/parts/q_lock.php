<?php
/**
 * Componente para quincena bloqueada
 * Muestra cuenta atrás y formulario de suscripción sobre fondo desenfocado
 */
global $panel_id;

$q_field = isset($args['q_field']) ? $args['q_field'] : 'panel_q1_unlock_day';
$phase = isset($args['phase']) ? $args['phase'] : 'q1';
$unlocked = isset($args['unlocked']) ? $args['unlocked'] : 'false';

$unlock_date = okisam_get_q_unlock_date($panel_id, $q_field);
$panel_image = get_field('panel_image', $panel_id);
$bg_url = ($panel_image && isset($panel_image['url'])) ? $panel_image['url'] : '';

// Get remaining seconds using WordPress current time to avoid timezone issues
$unlock_timestamp = strtotime($unlock_date);
$current_timestamp = current_time('timestamp');
$remaining_seconds = $unlock_timestamp - $current_timestamp;
?>

<div  class="locked-overlay" data-phase="<?php echo esc_attr($phase); ?>" data-unlocked="<?php echo esc_attr($unlocked); ?>">
    <div id="newsletter"  class="q-lock-content text-neutral-00 text-center">
        <h2 class="h1-semibold mb-30">Nuevo contenido en</h2>

        <div class="q-lock-countdown js-countdown mb-40" data-remaining="<?php echo esc_attr($remaining_seconds); ?>">
                <div class="countdown-item">
                    <span class="countdown-value h1-semibold" data-days>00</span>
                    <span class="countdown-label body-l-regular">Días</span>
                </div>
                <div class="countdown-separator h1-semibold">:</div>
                <div class="countdown-item">
                    <span class="countdown-value h1-semibold" data-hours>00</span>
                    <span class="countdown-label body-l-regular">Horas</span>
                </div>
                <div class="countdown-separator h1-semibold">:</div>
                <div class="countdown-item">
                    <span class="countdown-value h1-semibold" data-mins>00</span>
                    <span class="countdown-label body-l-regular">Mins</span>
                </div>
                <div class="countdown-separator h1-semibold">:</div>
                <div class="countdown-item">
                    <span class="countdown-value h1-semibold" data-secs>00</span>
                    <span class="countdown-label body-l-regular">Secs</span>
                </div>
            </div>

            <form action="https://okisam.activehosted.com/proc.php" method="POST" class="q-lock-form mb-30" id="_form_316_">
                <input type="hidden" name="u" value="316" />
                <input type="hidden" name="f" value="316" />
                <input type="hidden" name="s" />
                <input type="hidden" name="c" value="0" />
                <input type="hidden" name="m" value="0" />
                <input type="hidden" name="act" value="sub" />
                <input type="hidden" name="v" value="2" />
                <input type="hidden" name="or" value="46c7d1e9-b05a-4a3d-b17d-576bc07428f8" />

                <!-- UTM Fields -->
                <input type="hidden" name="field[143]" id="utm_source_ac" value="" />
                <input type="hidden" name="field[144]" id="utm_medium_ac" value="" />
                <input type="hidden" name="field[145]" id="utm_campaign_ac" value="" />
                <input type="hidden" name="field[188]" id="utm_content_ac" value="" />
                <input type="hidden" name="field[189]" id="utm_term_ac" value="" />

                <div class="subscription-input-group">
                    <div class="input-with-icon">
                        <!-- Email Svg -->
                        <svg width="35" height="33" viewBox="0 0 35 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_195_16194)">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.17609 7.02787C4.16145 7.02787 3.32669 7.86262 3.32669 8.87726V26.6314C3.32669 27.6461 4.16145 28.4808 5.17609 28.4808H28.8483C29.863 28.4808 30.6977 27.6461 30.6977 26.6314V8.87726C30.6977 7.86262 29.863 7.02787 28.8483 7.02787H5.17609ZM1.10742 8.87726C1.10742 6.63696 2.93579 4.80859 5.17609 4.80859H28.8483C31.0886 4.80859 32.917 6.63696 32.917 8.87726V26.6314C32.917 28.8717 31.0886 30.7001 28.8483 30.7001H5.17609C2.93579 30.7001 1.10742 28.8717 1.10742 26.6314V8.87726Z" fill="#AEAEAE"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.30811 8.24098C1.65955 7.73892 2.35143 7.61682 2.85349 7.96826L17.0123 17.8795L31.1711 7.96826C31.6731 7.61682 32.3651 7.73892 32.7165 8.24098C33.068 8.74303 32.9458 9.43492 32.4438 9.78636L17.6486 20.143C17.2666 20.4105 16.758 20.4105 16.376 20.143L1.58083 9.78636C1.07877 9.43492 0.956662 8.74303 1.30811 8.24098Z" fill="#AEAEAE"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_195_16194">
                        <rect width="34.0288" height="32.5493" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                        <!-- Email Svg -->
                        <input type="email" name="email" placeholder="Tu correo electrónico" required class="h4-regular text-neutral-90">
                    </div>
                    <button type="submit" class="btn-form-newsletter bg-brand text-neutral-00 h3-regular" data-cta="subscription">Suscríbete ya</button>
                </div>
                
                <div class="form-legal text-left mt-30">
                    <label class="checkbox-container body-s-regular">
                        <input type="checkbox" name="field[24]" value="1" required>
                        <span class="checkmark"></span>
                        He Leído, entiendo y acepto <a href="#" class="text-neutral-00 underline">política de privacidad</a> y <a href="#" class="text-neutral-00 underline">Condiciones de Uso</a> *.
                        <p class="legal-text body-s-regular mt-15">
                            De conformidad con lo establecido en el REGLAMENTO (UE) 2016/679 de protección de datos de carácter personal (RGPD), le informamos que los datos que usted nos facilite serán incorporados al sistema de tratamiento titularidad de Okisam, y domicilio social sito en C/Espinosa 13, (bajo izq.) 46008, Valencia. Con la finalidad de PUBLICIDAD Y PROSPECCIÓN COMERCIAL. He Leído, entiendo y acepto <a href="#" class="text-neutral-00 underline">política de privacidad</a> y <a href="#" class="text-neutral-00 underline">Condiciones de Uso</a> *
                        </p>
                    </label>
                </div>
                <div class="form-messages mt-20"></div>
            </form>
        </div>
    </div>
</div>
