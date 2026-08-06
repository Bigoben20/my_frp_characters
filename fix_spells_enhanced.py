#!/usr/bin/env python3
"""
Enhanced script to fix the spells.sql file with proper descriptions and structure
"""

import re

def fix_sql_file_enhanced():
    input_file = '/Users/bigoben20/Desktop/frp/spells.sql'
    output_file = '/Users/bigoben20/Desktop/İş/3-MyProjects/my_frp_characters/spells_complete.sql'
    
    # Common spell descriptions for missing ones
    default_descriptions = {
        'Antimagic Field': 'A 10-foot-radius invisible sphere of antimagic surrounds you. This area is divorced from the magical energy that suffuses the multiverse.',
        'Antipathy/Sympathy': 'This spell attracts or repels creatures of your choice. You target something within range, either a Huge or smaller object or creature or an area that is no larger than a 200-foot cube.',
        'Arcane Eye': 'You create an invisible, magical eye within range that hovers in the air for the duration.',
        'Arcane Gate': 'You create linked teleportation portals that remain open for the duration.',
        'Arcane Lock': 'You touch a closed door, window, gate, chest, or other entryway, and it becomes locked for the duration.',
        'Arcane Vigor': 'Choose a creature within range. The target regains a number of hit points equal to 2d4 + your spellcasting ability modifier.',
        'Armor of Agathys': 'A protective magical force surrounds you, manifesting as a spectral frost that covers you and your gear.',
    }
    
    with open(input_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Process line by line and fix structure
    lines = content.split('\n')
    fixed_lines = []
    
    for line in lines:
        if line.strip().startswith('(') and 'spells' not in line:
            # This is a values line
            # Extract values more carefully
            line_content = line.strip()
            if line_content.endswith(','):
                line_content = line_content[:-1]
            
            # Remove parentheses
            values_str = line_content[1:-1]
            
            # Split values while respecting quotes
            values = []
            current_value = ""
            in_quotes = False
            quote_char = None
            paren_count = 0
            
            i = 0
            while i < len(values_str):
                char = values_str[i]
                
                if char == '(' and not in_quotes:
                    paren_count += 1
                elif char == ')' and not in_quotes:
                    paren_count -= 1
                elif not in_quotes and char in ["'"]:
                    in_quotes = True
                    quote_char = char
                elif in_quotes and char == quote_char:
                    # Check if next char is also quote (escaped)
                    if i + 1 < len(values_str) and values_str[i + 1] == quote_char:
                        current_value += char + char
                        i += 1  # Skip next char
                    else:
                        current_value += char
                        in_quotes = False
                        quote_char = None
                elif not in_quotes and char == ',' and paren_count == 0:
                    values.append(current_value.strip())
                    current_value = ""
                else:
                    current_value += char
                
                i += 1
            
            # Add the last value
            if current_value.strip():
                values.append(current_value.strip())
            
            # Ensure we have exactly 17 fields
            while len(values) < 17:
                values.append('NULL')
            
            # Fix the structure according to your requirements:
            # id, name, level, school, casting_time, range, area, components, duration, concentration, ritual, classes, description, higher_levels, img_url, created_at, updated_at
            
            if len(values) >= 12:
                spell_name = values[1].strip("'\"")
                
                # Check if description field is actually a URL
                description_field = values[12] if len(values) > 12 else 'NULL'
                img_url_field = 'NULL'
                
                if description_field.startswith(("'http", '"http')):
                    img_url_field = description_field
                    # Try to use default description
                    if spell_name in default_descriptions:
                        description_field = f"'{default_descriptions[spell_name]}'"
                    else:
                        description_field = 'NULL'
                
                # Reconstruct with proper order
                new_values = values[:12]  # Keep first 12 as is
                new_values.append(description_field)  # description
                new_values.append('NULL')  # higher_levels
                new_values.append(img_url_field)  # img_url
                new_values.append('NULL')  # created_at
                new_values.append('NULL')  # updated_at
                
                fixed_line = "(" + ", ".join(new_values[:17]) + ")"
                if not line.strip().endswith(';'):
                    fixed_line += ","
                
                fixed_lines.append(fixed_line)
            else:
                fixed_lines.append(line)
        else:
            fixed_lines.append(line)
    
    # Join and fix the final format
    new_content = '\n'.join(fixed_lines)
    
    # Remove trailing comma before semicolon
    new_content = re.sub(r',\s*;', ';', new_content)
    
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(new_content)
    
    print(f"Enhanced SQL file saved as: {output_file}")

if __name__ == "__main__":
    fix_sql_file_enhanced()