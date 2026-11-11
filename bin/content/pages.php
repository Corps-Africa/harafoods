<?php
/**
 * Seed copy for HaRa Foods pages.
 *
 * Source: HaRa Foods' Corps Africa website-campaign application (Nov 2026).
 * Anything we could not confirm from that application is marked "[to be confirmed]"
 * or kept general — replace with HaRa Foods' final text before launch.
 */

function hara_pages() {
	$u = function ( $path ) { return home_url( $path ); };

	/* ================================================================ HOME */
	$home =
		hb_section(
			hb_columns( array(
				array(
					hb_p( 'Solar-dried in Bole, Savannah Region', 'hara-eyebrow' )
					. hb_h( 'Naturally <em>solar-dried</em> goodness from Northern Ghana', 1 )
					. hb_p( 'We turn fresh produce from local farmers into nutritious, convenient foods — preserved with the power of the sun, so less of every harvest goes to waste.', 'hara-lead' )
					. hb_buttons( array(
						array( 'Shop our products', $u( '/shop/' ) ),
						array( 'Wholesale & partnerships', $u( '/wholesale/' ), true ),
					) )
					. hb_p( 'Pay with Mobile Money or card · Delivery across Ghana', 'hara-hero__note' ),
					'54%',
				),
				array( hb_group( '', 'hara-hero__art' ), '46%' ),
			), '', 'center' ),
			'hara-hero'
		)
		. hb_section(
			hb_columns( array(
				hb_group( hb_h( 'Powered by the sun', 3 ) . hb_p( 'Our solar dehydration preserves fresh produce with clean energy, locking in flavour and extending shelf life.' ), 'hara-value' ),
				hb_group( hb_h( 'Sourced from local farmers', 3 ) . hb_p( 'We buy from smallholder farmers in the Savannah Region, building reliable markets for their harvests.' ), 'hara-value' ),
				hb_group( hb_h( 'Nutritious & convenient', 3 ) . hb_p( 'Ready-to-use fruits, vegetables, powders and mixes that make healthy eating easier every day.' ), 'hara-value' ),
				hb_group( hb_h( 'Less food wasted', 3 ) . hb_p( 'Drying surplus produce at harvest time reduces post-harvest losses and keeps good food in the food system.' ), 'hara-value' ),
			) ),
			'hara-values hara-reveal'
		)
		. hb_section(
			hb_head( 'Our products', 'Shop the solar-dried range', 'Dried fruits, vegetable powders, spices and drink mixes — made in small batches in Bole.' )
			. hb_shortcode( '[products limit="8" columns="4" visibility="featured" orderby="menu_order" order="ASC"]' )
			. hb_buttons( array( array( 'View all products', $u( '/shop/' ), true ) ), 'center' ),
			'hara-reveal'
		)
		. hb_section(
			hb_head( 'How it works', 'From farm to pantry', 'Every HaRa product follows the same simple journey.', true )
			. hb_columns( array(
				hb_group( hb_h( 'Sourced locally', 3 ) . hb_p( 'Fresh, in-season produce is bought directly from farmers in and around Bole.' ), 'hara-step' ),
				hb_group( hb_h( 'Cleaned & prepared', 3 ) . hb_p( 'Produce is sorted, washed and cut by our processing team.' ), 'hara-step' ),
				hb_group( hb_h( 'Solar dried', 3 ) . hb_p( 'Our solar dehydrators gently remove moisture using clean energy from the sun.' ), 'hara-step' ),
				hb_group( hb_h( 'Packed & delivered', 3 ) . hb_p( 'Products are packed, labelled and sent to homes, shops and institutions across Ghana.' ), 'hara-step' ),
			), 'hara-steps' ),
			'hara-section--sand hara-reveal'
		)
		. hb_section(
			hb_columns( array(
				array(
					hb_p( 'Our impact', 'hara-eyebrow' )
					. hb_h( 'Food security starts at harvest' )
					. hb_p( 'Across Northern Ghana, a large share of fruits and vegetables is lost between the farm and the market. HaRa Foods exists to change that — while improving nutrition and creating jobs for women and young people.', 'hara-lead' )
					. hb_buttons( array( array( 'See our impact', $u( '/impact/' ) ), array( 'Partner with us', $u( '/wholesale/' ), true ) ) ),
					'42%',
				),
				array(
					hb_columns( array(
						hb_group( hb_h( 'Reducing post-harvest losses', 3 ) . hb_p( 'Surplus produce is dried and preserved instead of spoiling.' ), 'hara-pillar' ),
						hb_group( hb_h( 'Improving nutrition', 3 ) . hb_p( 'Nutritious, shelf-stable foods for families, schools and health facilities.' ), 'hara-pillar' ),
						hb_group( hb_h( 'Creating livelihoods', 3 ) . hb_p( 'Fair markets for farmers and jobs for women and young people.' ), 'hara-pillar' ),
					) ),
					'58%',
				),
			), '', 'center' ),
			'hara-dark hara-reveal'
		)
		. hb_section(
			hb_head( 'Kind words', 'What our customers and partners say', '', true )
			. hb_shortcode( '[hara_testimonials count="3"]' ),
			'hara-reveal'
		)
		. hb_section(
			hb_group(
				hb_h( 'Stock HaRa Foods in your shop, school, hotel or clinic' )
				. hb_p( 'We supply retailers, supermarkets, restaurants, hotels, schools, healthcare facilities and distributors. Tell us what you need and we’ll send wholesale prices.' )
				. hb_buttons( array( array( 'Request wholesale prices', $u( '/wholesale/' ) ), array( 'Chat with us', $u( '/contact/' ), true ) ) ),
				'hara-cta'
			),
			'hara-section--tight hara-reveal'
		)
		. hb_section(
			hb_head( 'News & stories', 'From our blog' )
			. hb_shortcode( '[hara_latest_posts count="3"]' ),
			'hara-section--white hara-reveal'
		)
		. hb_section(
			hb_shortcode( '[hara_instagram]' ),
			'hara-section--tight hara-section--white'
		);

	/* ================================================================ ABOUT */
	$about =
		hb_section(
			hb_columns( array(
				array(
					hb_p( 'Our story', 'hara-eyebrow' )
					. hb_h( 'Born in Bole, built around the harvest' )
					. hb_p( 'HaRa Foods Ltd is an agribusiness and food-processing enterprise based in Bole, in Ghana’s Savannah Region. We started with a simple observation: in our community, good food is lost every season because there is no way to keep it — while many families still struggle to get enough nutritious food.' )
					. hb_p( 'So we set out to bridge that gap. Using sustainable processing technologies, including solar dehydration, we transform locally available produce into nutritious, convenient and value-added food products that last.' )
					. hb_p( '<em>[To be confirmed: founding year and a few lines of Diana’s personal story.]</em>' ),
					'58%',
				),
				array( hb_group( '', 'hara-hero__art' ), '42%' ),
			), '', 'center' )
		)
		. hb_section(
			hb_columns( array(
				hb_group( hb_p( 'Mission', 'hara-eyebrow' ) . hb_h( 'What we do every day', 3 ) . hb_p( 'To reduce post-harvest losses and fight malnutrition by turning local produce into nutritious, convenient foods — using clean, sustainable processing.' ), 'hara-value' ),
				hb_group( hb_p( 'Vision', 'hara-eyebrow' ) . hb_h( 'Where we are going', 3 ) . hb_p( 'A Northern Ghana where every harvest feeds more people, farmers earn more from what they grow, and nutritious food is within everyone’s reach. <em>[Vision statement to be confirmed.]</em>' ), 'hara-value' ),
				hb_group( hb_p( 'Values', 'hara-eyebrow' ) . hb_h( 'How we work', 3 ) . hb_list( array( 'Quality and food safety first', 'Fair partnerships with farmers', 'Opportunity for women and youth', 'Care for the environment' ) ), 'hara-value' ),
			) ),
			'hara-section--sand'
		)
		. hb_section(
			hb_head( 'Leadership', 'The people behind HaRa Foods', 'A growing team of food processors, farmers’ partners and community builders.' )
			. hb_columns( array(
				hb_group( hb_p( 'Photo coming soon', 'hara-avatar-placeholder' ) . hb_h( 'Diana Rashida Rashid', 3 ) . hb_p( 'Founder &amp; CEO', 'hara-role' ) . hb_p( '[Short bio to be supplied by HaRa Foods.]' ) ),
				hb_group( hb_p( 'Photo coming soon', 'hara-avatar-placeholder' ) . hb_h( '[Team member]', 3 ) . hb_p( '[Role]', 'hara-role' ) . hb_p( '[Short bio]' ) ),
				hb_group( hb_p( 'Photo coming soon', 'hara-avatar-placeholder' ) . hb_h( '[Team member]', 3 ) . hb_p( '[Role]', 'hara-role' ) . hb_p( '[Short bio]' ) ),
			), 'hara-team' )
		)
		. hb_section(
			hb_group(
				hb_h( 'Want to work with us?' )
				. hb_p( 'We partner with farmers, buyers, development organisations and investors who share our goals.' )
				. hb_buttons( array( array( 'Partner with us', $u( '/wholesale/' ) ), array( 'Shop products', $u( '/shop/' ), true ) ) ),
				'hara-cta'
			),
			'hara-section--tight'
		);

	/* ================================================================ IMPACT */
	$impact =
		hb_section(
			hb_head( 'Why it matters', 'Good food shouldn’t go to waste', 'In the Savannah Region, much of what farmers grow is harvested in a short season. Without ways to store or process it, produce spoils — farmers lose income and families lose access to nutritious food later in the year.' )
			. hb_columns( array(
				hb_group( hb_h( 'Reducing post-harvest losses', 3 ) . hb_p( 'By buying surplus produce at harvest and drying it, we keep food in the food system and give farmers a reliable market.' ), 'hara-value' ),
				hb_group( hb_h( 'Improving nutrition', 3 ) . hb_p( 'Dried fruits, vegetables and powders make nutritious ingredients available all year — for households, schools and health facilities.' ), 'hara-value' ),
				hb_group( hb_h( 'Empowering women & youth', 3 ) . hb_p( 'Processing, packaging and distribution create skilled jobs and business opportunities for women and young people in our community.' ), 'hara-value' ),
				hb_group( hb_h( 'Using clean energy', 3 ) . hb_p( 'Solar drying uses the sun instead of firewood or grid electricity, lowering costs and environmental impact.' ), 'hara-value' ),
			) )
		)
		. hb_section(
			hb_head( 'Progress so far', 'Our impact in numbers', 'Figures to be supplied by HaRa Foods. Update these as you grow.' )
			. hb_columns( array(
				hb_group( hb_p( '[#]', 'hara-stat__num' ) . hb_p( 'farmers we buy from' ), 'hara-stat' ),
				hb_group( hb_p( '[#] kg', 'hara-stat__num' ) . hb_p( 'produce saved from waste' ), 'hara-stat' ),
				hb_group( hb_p( '[#]', 'hara-stat__num' ) . hb_p( 'women & young people employed' ), 'hara-stat' ),
				hb_group( hb_p( '[#]', 'hara-stat__num' ) . hb_p( 'shops & institutions supplied' ), 'hara-stat' ),
			), 'hara-stats' ),
			'hara-dark'
		)
		. hb_section(
			hb_head( 'Impact stories', 'Voices from our community' )
			. hb_shortcode( '[hara_testimonials count="6"]' )
		)
		. hb_section(
			hb_head( 'Partners', 'Who we work with', 'Logos and short descriptions of partners, funders and programmes HaRa Foods has worked with. [To be supplied by HaRa Foods.]' ),
			'hara-section--sand'
		)
		. hb_section(
			hb_group(
				hb_h( 'Invest in a more food-secure Northern Ghana' )
				. hb_p( 'We welcome conversations with investors, development partners and grant providers who want to scale solutions to post-harvest loss and malnutrition.' )
				. hb_buttons( array( array( 'Get in touch', $u( '/wholesale/' ) ) ) ),
				'hara-cta'
			),
			'hara-section--tight'
		);

	/* ================================================================ WHOLESALE */
	$wholesale =
		hb_section(
			hb_columns( array(
				array(
					hb_p( 'Wholesale & institutional supply', 'hara-eyebrow' )
					. hb_h( 'Bring HaRa Foods to your customers' )
					. hb_p( 'We supply solar-dried foods in bulk and retail-ready packs to:' )
					. hb_list( array( 'Retailers and supermarkets', 'Distributors', 'Restaurants and hotels', 'Schools and school-feeding programmes', 'Healthcare facilities' ) )
					. hb_p( 'Fill in the form and we’ll reply with our wholesale price list, minimum order quantities and delivery options — usually within 1–2 working days.' )
					. hb_h( 'Partners & investors', 3 )
					. hb_p( 'Development organisations, grant providers and investors: choose your organisation type in the form and tell us what you have in mind. We’re happy to share our business profile.' )
					. hb_shortcode( '[hara_whatsapp_button text="Prefer WhatsApp? Chat with us"]' ),
					'42%',
				),
				array( hb_shortcode( '[hara_wholesale_form]' ), '58%' ),
			) )
		);

	/* ================================================================ FAQ */
	$faq_items = array(
		'Products' => array(
			array( 'What does “solar dried” mean?', 'We dry fresh produce in solar dehydrators that use heat from the sun to remove moisture. This preserves the food naturally so it keeps for much longer than fresh produce.' ),
			array( 'How long do your products last?', 'Shelf life depends on the product and is printed on every pack. [To be confirmed by HaRa Foods: typical shelf life per product.]' ),
			array( 'How should I store them?', 'Keep packs sealed in a cool, dry place away from direct sunlight. After opening, reseal tightly or transfer to an airtight container.' ),
			array( 'Do you add preservatives or sugar?', '[To be confirmed by HaRa Foods for each product. Ingredients are listed on each product page and pack.]' ),
		),
		'Orders & delivery' => array(
			array( 'Where do you deliver?', 'We deliver across Ghana. Orders within the Savannah Region are delivered directly; orders to other regions are sent by trusted bus courier. You can also pick up for free from our facility in Bole.' ),
			array( 'How much is delivery and how long does it take?', 'Delivery fees are calculated at checkout based on your region. Most orders are dispatched within 1–3 working days. [Delivery times and fees to be confirmed.]' ),
			array( 'Can I track my order?', 'Yes. You’ll receive order updates by email, and we’ll call or WhatsApp you to arrange delivery.' ),
		),
		'Payment' => array(
			array( 'How can I pay?', 'Pay online with MTN MoMo, Telecel Cash, AirtelTigo Money, Visa or Mastercard through Paystack, or pay on delivery in cash or by Mobile Money.' ),
			array( 'Is online payment secure?', 'Yes. Online payments are processed by Paystack, a licensed payment provider. We never see or store your card or wallet details.' ),
		),
		'Wholesale & partnerships' => array(
			array( 'Do you sell in bulk?', 'Yes — we supply retailers, distributors, hotels, restaurants, schools and health facilities. <a href="' . esc_url( $u( '/wholesale/' ) ) . '">Request wholesale prices</a>.' ),
			array( 'I’m a farmer. Can I sell my produce to HaRa Foods?', 'We’re always looking to work with more farmers in the Savannah Region. <a href="' . esc_url( $u( '/contact/' ) ) . '">Contact us</a> with what you grow and where you’re based.' ),
		),
	);
	$faq = '';
	foreach ( $faq_items as $group => $items ) {
		$faq .= hb_h( $group, 2, 'hara-faq-group' );
		foreach ( $items as $qa ) {
			$faq .= hb_details( $qa[0], hb_p( $qa[1] ) );
		}
	}
	$faq .= hb_p( 'Still have a question? <a href="' . esc_url( $u( '/contact/' ) ) . '">Get in touch</a> — we’re happy to help.' );

	/* ================================================================ CONTACT */
	$contact =
		hb_section(
			hb_columns( array(
				array(
					hb_h( 'Talk to us', 2 )
					. hb_p( 'Questions about a product, an order or a partnership? Send us a message, call, or chat on WhatsApp.' )
					. hb_shortcode( '[hara_contact_details]' )
					. hb_shortcode( '[hara_social_links]' ),
					'40%',
				),
				array( hb_shortcode( '[hara_contact_form]' ), '60%' ),
			) )
		)
		. hb_section(
			hb_shortcode( '[hara_map height="420"]' ),
			'hara-section--tight'
		);

	/* ================================================================ LEGAL / HELP */
	$review = hb_p( '<em>Template — please review with HaRa Foods (and a legal adviser if needed) before launch.</em>' );

	$delivery =
		$review
		. hb_h( 'Delivery' )
		. hb_list( array(
			'We deliver to all regions of Ghana. Delivery fees are shown at checkout before you pay.',
			'Savannah Region: delivered directly by our team. Other regions: sent by bus courier — we’ll share the waybill and pickup details.',
			'Free pickup is available from our facility in Bole.',
			'Orders are usually dispatched within 1–3 working days of payment (or confirmation, for pay-on-delivery orders).',
		) )
		. hb_h( 'Returns & refunds' )
		. hb_p( 'Because our products are food, we can’t accept returns of opened packs. If your order arrives damaged, incorrect or past its best-before date, contact us within 48 hours with a photo and your order number, and we’ll replace the item or refund you.' )
		. hb_p( 'Refunds for online payments are made back to the original payment method (Mobile Money or card) through Paystack.' );

	$terms =
		$review
		. hb_h( 'About us' )
		. hb_p( 'This website is operated by HaRa Foods Ltd, Bole, Savannah Region, Ghana. Contact: harafoodsltd@gmail.com.' )
		. hb_h( 'Orders' )
		. hb_p( 'All orders are subject to availability. Prices are in Ghana cedis (GH₵). We may cancel an order and refund any payment if a product is unavailable or a price was displayed in error.' )
		. hb_h( 'Payment' )
		. hb_p( 'Online payments are processed securely by Paystack. Pay-on-delivery orders must be paid in full when the order is handed over.' )
		. hb_h( 'Delivery, returns and refunds' )
		. hb_p( 'See our <a href="' . esc_url( $u( '/delivery-returns/' ) ) . '">Delivery &amp; returns</a> page.' )
		. hb_h( 'Product information' )
		. hb_p( 'We take care to describe our products accurately. Product photos are for illustration; packaging may vary. Always read the label for ingredients and allergen information.' )
		. hb_h( 'Governing law' )
		. hb_p( 'These terms are governed by the laws of the Republic of Ghana.' );

	$privacy =
		$review
		. hb_p( 'HaRa Foods Ltd respects your privacy. This policy explains what we collect through this website and why, in line with Ghana’s Data Protection Act, 2012 (Act 843).' )
		. hb_h( 'What we collect' )
		. hb_list( array(
			'<strong>Orders:</strong> your name, phone number, email and delivery address, so we can process and deliver your order.',
			'<strong>Payments:</strong> processed by Paystack. We do not see or store your card or Mobile Money PIN.',
			'<strong>Enquiry forms:</strong> the details you type into our contact and wholesale forms, so we can reply.',
			'<strong>Accounts:</strong> if you create an account, your order history and saved addresses.',
		) )
		. hb_h( 'Third-party services' )
		. hb_p( 'This site uses Paystack (payments), Google Maps (map on the Contact page), Google Fonts (typography) and links to WhatsApp, Instagram and LinkedIn. These services may process data according to their own privacy policies.' )
		. hb_h( 'How long we keep it' )
		. hb_p( 'We keep order records for as long as required for accounting and tax purposes, and enquiry messages for up to two years.' )
		. hb_h( 'Your rights' )
		. hb_p( 'You can ask us to access, correct or delete your personal information by emailing harafoodsltd@gmail.com.' );

	return array(
		'home'             => array( 'title' => 'Home', 'content' => $home ),
		'about'            => array( 'title' => 'About us', 'excerpt' => 'We’re a Ghanaian agribusiness turning local harvests into nutritious, solar-dried foods — and better livelihoods for our community.', 'content' => $about ),
		'impact'           => array( 'title' => 'Our impact', 'excerpt' => 'Reducing post-harvest losses, improving nutrition and creating opportunities for women, young people and farmers in the Savannah Region.', 'content' => $impact ),
		'wholesale'        => array( 'title' => 'Wholesale & partnerships', 'excerpt' => 'Bulk supply for retailers, distributors, hotels, restaurants, schools and health facilities — and partnerships with organisations that share our mission.', 'content' => $wholesale ),
		'news'             => array( 'title' => 'News & stories', 'excerpt' => 'Updates from our team, our farmers and our community in the Savannah Region.', 'content' => '' ),
		'faq'              => array( 'title' => 'Frequently asked questions', 'excerpt' => 'Everything you need to know about our products, delivery and payment.', 'content' => $faq ),
		'contact'          => array( 'title' => 'Contact us', 'excerpt' => 'We’d love to hear from you — customers, farmers, buyers and partners alike.', 'content' => $contact ),
		'delivery-returns' => array( 'title' => 'Delivery & returns', 'content' => $delivery ),
		'terms'            => array( 'title' => 'Terms & conditions', 'content' => $terms ),
		'privacy-policy'   => array( 'title' => 'Privacy policy', 'content' => $privacy ),
	);
}
