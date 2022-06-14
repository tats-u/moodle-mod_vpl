<?php
// This file is part of VPL for Moodle - http://vpl.dis.ulpgc.es/
//
// VPL for Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// VPL for Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with VPL for Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Unit tests for class tokenizer mod/vpl/similarity/tokenizer.class.php
 *
 * @package mod_vpl
 * @copyright David Parreño Barbuzano
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author  David Parreño Barbuzano <david.parreno101@alu.ulpgc.es>
 */
namespace mod_vpl;

defined('MOODLE_INTERNAL') || die();

use mod_vpl\tokenizer\tokenizer;
use mod_vpl\util\assertf;
use Exception;

global $CFG;
require_once($CFG->dirroot . '/mod/vpl/tests/base_test.php');

/**
 * Unit tests for \mod_vpl\tokenizer\tokenizer class.
 *
 * @group mod_vpl
 * @group mod_vpl_tokenizer
 * @covers \mod_vpl\tokenizer\tokenizer
 */
class tokenizer_test extends \advanced_testcase {
    /**
     * Method to test tokenizer::load_json when file does not exist
     */
    public function test_unexisted_file() {
        $filename = self::get_test_path() . 'dump_test.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'file ' . $filename . ' must exist');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::load_json when file does not have a valid suffix
     */
    public function test_not_good_suffix() {
        $filename = self::get_test_path() . 'invalid/general/not_good_suffix.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, $filename . ' must have suffix _highlight_rules.json');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::load_json when file is empty
     */
    public function test_empty_file() {
        $filename = self::get_test_path() . 'invalid/general/empty_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'file ' . $filename . ' is empty');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when key is not valid
     */
    public function test_invalid_key_option() {
        $filename = self::get_test_path() . 'invalid/general/undefined_option_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'invalid options: example');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::discard_comments
     */
    public function test_discard_comments() {
        $dir = self::get_test_path() . 'valid/comments';

        $scanarr = scandir($dir);
        $filesarr = array_diff($scanarr, array('.', '..'));

        foreach ($filesarr as $filename) {
            $filename = $dir . '/' . $filename;

            try {
                $tokenizer = new tokenizer($filename);
            } catch (Exception $exe) {
                echo($exe->getMessage() . "\n");
                $this->fail();
                break;
            }
        }
    }

    /**
     * Method to test tokenizer::check_json_file when check_rules is not valid
     */
    public function test_invalid_check_rules() {
        $filename = self::get_test_path() . 'invalid/general/invalid_check_rules_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, '"check_rules" option must be a boolean');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when name is not valid
     */
    public function test_invalid_name() {
        $filename = self::get_test_path() . 'invalid/general/invalid_name_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, '"name" option must be a string');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when extension is not valid as a string
     */
    public function test_invalid_ext_string() {
        $filename = self::get_test_path() . 'invalid/general/invalid_extension_no_string_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, '"extension" option must be a string or an array of strings');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when extension is not valid as an array
     */
    public function test_invalid_ext_array() {
        $filename = self::get_test_path() . 'invalid/general/invalid_extension_no_array_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, '"extension" option must be a string or an array of strings');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when extension does not start with .
     */
    public function test_invalid_ext_no_dot() {
        $filename = self::get_test_path() . 'invalid/general/invalid_extension_no_dot_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'extension c must start with .');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when inherit_rules is not valid
     */
    public function test_invalid_inherit_rules() {
        $filename = self::get_test_path() . 'invalid/general/invalid_inherit_rules_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, '"inherit_rules" option must be a string');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when inherit_rules has a not valid json
     */
    public function test_invalid_json_inherit_rules() {
        $filename = self::get_test_path() . 'invalid/general/invalid_json_inheritance_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $errmssg = 'inherit JSON file ' . self::get_test_path();
            $errmssg .= 'invalid/general/dump_highlight_rules.json does not exist';
            $expectedmssg = assertf::get_error($filename,  $errmssg);
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when states is not valid
     */
    public function test_invalid_states() {
        $filename = self::get_test_path() . 'invalid/states/invalid_data_states_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, '"states" option must be an array');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when a state has no name
     */
    public function test_state_with_no_name() {
        $filename = self::get_test_path() . 'invalid/states/states_with_no_name_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'state 0 must have a name');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when state is not an object
     */
    public function test_invalid_state() {
        $filename = self::get_test_path() . 'invalid/states/state_not_object_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'state 0 must be an object');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when state has an invalid name
     */
    public function test_invalid_state_name() {
        $filename = self::get_test_path() . 'invalid/states/invalid_state_name_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'name for state 0 must be a string');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when state's data is invalid
     */
    public function test_invalid_data_state() {
        $filename = self::get_test_path() . 'invalid/states/invalid_data_state_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'data section for state "state1" nº0 must be an array');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when a state has no data
     */
    public function test_state_with_no_data() {
        $filename = self::get_test_path() . 'invalid/states/state_with_no_data_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'state "state1" nº0 must have a data section');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when a state is duplicated
     */
    public function test_duplicated_state() {
        $filename = self::get_test_path() . 'invalid/states/duplicated_state_name_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'name "state1" of state 2 is duplicated');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when one state has no name
     */
    public function test_one_state_with_no_name() {
        $filename = self::get_test_path() . 'invalid/states/one_state_with_no_name_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'state 1 must have a name');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when rule is not valid
     */
    public function test_invalid_rule() {
        $filename = self::get_test_path() . 'invalid/rules/invalid_rule_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'rule 0 of state "state1" nº0 must be an object');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when rule's option is not valid
     */
    public function test_invalid_rule_option_value() {
        $filename = self::get_test_path() . 'invalid/rules/invalid_rule_option_value_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'invalid data type for token at rule 0 of state "state1" nº0');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when rule option key is not valid
     */
    public function test_undefined_rule_option() {
        $filename = self::get_test_path() . 'invalid/rules/undefined_rule_option_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'invalid option example at rule 0 of state "state1" nº0');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when next is invalid
     */
    public function test_invalid_next() {
        $filename = self::get_test_path() . 'invalid/rules/invalid_next_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'invalid data type for next at rule 0 of state "state1" nº0 (next: 0)');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when next has one invalid option
     */
    public function test_invalid_next_option() {
        $filename = self::get_test_path() . 'invalid/rules/invalid_next_option_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'invalid data type for token at rule 0 of state "state1" nº0 (next: 0)');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when next has one invalid rule
     */
    public function test_invalid_next_one_rule() {
        $filename = self::get_test_path() . 'invalid/rules/invalid_next_one_rule_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'invalid data type for next at rule 1 of state "state1" nº0 (next: 0)');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::check_json_file when sub next is invalid
     */
    public function test_invalid_sub_next() {
        $filename = self::get_test_path() . 'invalid/rules/invalid_sub_next_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'invalid data type for next at rule 0 of state "state1" nº0 (next: 1)');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    public function test_required_group_regex() {
        $filename = self::get_test_path() . 'invalid/rules/regex_not_found_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'missing options regex at rule 0 of state "state1" nº0');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    public function test_required_group_token() {
        $filename = self::get_test_path() . 'invalid/rules/token_not_found_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'missing options token at rule 0 of state "state1" nº0');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }

    /**
     * Method to test tokenizer::merge_json_files when inherit is just one state
     */
    public function test_merge_one_state() {
        $filename = self::get_test_path() . 'valid/merge/test_merge_1_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
            $states = $tokenizer->get_states();

            $this->assertTrue(count($states) == 2);

            $this->assertTrue(in_array("root", array_keys($states)));
            $this->assertSame("root", $states["root"]->name);
            $this->assertTrue(count($states["root"]->data) == 1);
            $this->assertSame("comment", $states["root"]->data[0]->token);
            $this->assertSame("//", $states["root"]->data[0]->regex);
            $this->assertSame("text-state", $states["root"]->data[0]->next);

            $this->assertTrue(in_array("text-state", array_keys($states)));
            $this->assertSame("text-state", $states["text-state"]->name);
            $this->assertTrue(count($states["text-state"]->data) == 1);
            $this->assertSame("text", $states["text-state"]->data[0]->token);
            $this->assertSame(".*", $states["text-state"]->data[0]->regex);
        } catch (Exception $exe) {
            echo($exe->getMessage() . "\n");
            $this->fail();
        }
    }

    /**
     * Method to test tokenizer::merge_json_files when inherit is just one state but there are two states at root file
     */
    public function test_merge_two_states_from_root() {
        $filename = self::get_test_path() . 'valid/merge/test_merge_2_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
            $states = $tokenizer->get_states();

            $this->assertTrue(count($states) == 3);

            $this->assertTrue(in_array("root", array_keys($states)));
            $this->assertSame("root", $states["root"]->name);
            $this->assertTrue(count($states["root"]->data) == 1);
            $this->assertSame("comment", $states["root"]->data[0]->token);
            $this->assertSame("//", $states["root"]->data[0]->regex);
            $this->assertSame("text-state", $states["root"]->data[0]->next);

            $this->assertTrue(in_array("eol", array_keys($states)));
            $this->assertSame("eol", $states["eol"]->name);
            $this->assertTrue(count($states["eol"]->data) == 1);
            $this->assertSame("eol", $states["eol"]->data[0]->token);
            $this->assertSame("\n", $states["eol"]->data[0]->regex);

            $this->assertTrue(in_array("text-state", array_keys($states)));
            $this->assertSame("text-state", $states["text-state"]->name);
            $this->assertTrue(count($states["text-state"]->data) == 1);
            $this->assertSame("text", $states["text-state"]->data[0]->token);
            $this->assertSame(".*", $states["text-state"]->data[0]->regex);
        } catch (Exception $exe) {
            echo($exe->getMessage() . "\n");
            $this->fail();
        }
    }

    /**
     * Method to test tokenizer::merge_json_files when inherit has two states
     */
    public function test_merge_two_states_from_inheritance() {
        $filename = self::get_test_path() . 'valid/merge/test_merge_3_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
            $states = $tokenizer->get_states();

            $this->assertTrue(count($states) == 3);

            $this->assertTrue(in_array("root", array_keys($states)));
            $this->assertSame("root", $states["root"]->name);
            $this->assertTrue(count($states["root"]->data) == 1);
            $this->assertSame("comment", $states["root"]->data[0]->token);
            $this->assertSame("//", $states["root"]->data[0]->regex);
            $this->assertSame("text-state", $states["root"]->data[0]->next);

            $this->assertTrue(in_array("eol", array_keys($states)));
            $this->assertSame("eol", $states["eol"]->name);
            $this->assertTrue(count($states["eol"]->data) == 1);
            $this->assertSame("eol", $states["eol"]->data[0]->token);
            $this->assertSame("\n", $states["eol"]->data[0]->regex);

            $this->assertTrue(in_array("text-state", array_keys($states)));
            $this->assertSame("text-state", $states["text-state"]->name);
            $this->assertTrue(count($states["text-state"]->data) == 1);
            $this->assertSame("text", $states["text-state"]->data[0]->token);
            $this->assertSame(".*", $states["text-state"]->data[0]->regex);
        } catch (Exception $exe) {
            echo($exe->getMessage() . "\n");
            $this->fail();
        }
    }

    /**
     * Method to test tokenizer::prepare_tokenizer when number of groups doesn't match for token
     */
    /*
    public function test_invalid_number_groups_for_token() {
        $filename = self::get_test_path() . 'invalid/rule/invalid_number_groups_for_token_highlight_rules.json';

        try {
            $tokenizer = new tokenizer($filename);
        } catch (Exception $exe) {
            $expectedmssg = assertf::get_error($filename, 'number of classes and regex groups doesn\'t match');
            $this->assertSame($expectedmssg, $exe->getMessage());
            return;
        }

        $this->fail();
    }
    */

    private static function get_test_path(): string {
        return dirname(__FILE__) . '/vpl_tokenizer/';
    }
}
